<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Shipping;
use App\Models\Blacklist;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Models\CustomerOrders;
use App\Models\ShippingCompany;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Helpers\GoogleSheetsHelper;
use Illuminate\Support\Facades\Log;
use App\Filters\CustomerOrderFilter;
use App\Jobs\ExportOrderToGoogleSheet;
use App\Traits\PermissionMiddlewareTrait;
use App\Http\Requests\StoreCustomerOrderRequest;
use App\Services\Shipping\ShippingServiceInterface;
use App\Services\OrderDistributionService; // ✨ --- إضافة مهمة --- ✨


class CustomerOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PermissionMiddlewareTrait;
    public function __construct()
    {
        $this->middleware('store.locale');
        // $this->applyPermissionMiddleware('customer_orders');
    }

    /**
     * عرض قائمة الطلبات
     * ✨ --- تم تعديل هذه الدالة --- ✨
     */
    public function index(CustomerOrderFilter $filter)
    {
        $shippings = Shipping::all();

        // ابدأ ببناء الاستعلام
        $ordersQuery = CustomerOrders::filter($filter)
            ->with(['product', 'state', 'municipality']);

        // --- بداية التعديل الجوهري هنا ---
        if (auth()->user()->hasRole('confirmer') && !auth()->user()->hasRole('admin')) {
            // المؤكد يرى فقط الطلبات المعينة له
            $ordersQuery->where('assigned_to_user_id', auth()->id());
        }
        // المدير يرى كل شيء
        // --- نهاية التعديل الجوهري ---

        $orders = $ordersQuery->latest()->paginate(20);

        $company=ShippingCompany::where('is_active',1)->first();


        $statusCounts = CustomerOrders::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('customer_orders.index', compact('orders', 'statusCounts', 'shippings','company'));
    }

    /**
     * تخزين طلب جديد
     * ✨ --- تم تعديل هذه الدالة --- ✨
     */
    public function store(StoreCustomerOrderRequest $request)
    {
        $validatedData = $request->validated();

        // التحقق من القائمة السوداء
        $isBlacklisted = Blacklist::where('phone', $validatedData['phone'])
                                     ->orWhere('ip_address', $request->ip())
                                     ->exists();

        if ($isBlacklisted) {
            abort(403);
        }

        // معالجة حقل attributes وتحويله لـ JSON
        $attributeCombination = [];
        if (isset($validatedData['attributes'])) {
            foreach ($validatedData['attributes'] as $attributeId => $valueId) {
                $attributeCombination[] = [
                    'attribute_id' => (int)$attributeId,
                    'value_id' => (int)$valueId,
                ];
            }
        }

        // تحديد نوع الجهاز
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent()); // نمرر له معلومات الطلب
        $platform = $agent->platform() ?: 'Unknown';
    $browser = $agent->browser() ?: 'Unknown';
    $parsed_user_agent = $platform . ' - ' . $browser;
        $deviceType = 'desktop';
        if ($agent->isMobile()) {
            $deviceType = 'mobile';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        }

        // إنشاء الطلب
        $order = CustomerOrders::create([
            'product_id' => $validatedData['product_id'],
            'quantity' => $validatedData['quantity'],
            'fullname' => $validatedData['fullname'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'] ?? null,
            'state_id' => $validatedData['state_id'],
            'municipality_id' => $validatedData['municipality_id'],
            'address' => $validatedData['address'] ?? null,
            'delivery_type' => $validatedData['delivery_type'],
            'delivery_price' => $validatedData['delivery_price'],
            'total_price' => $validatedData['total_price'],
            'status' => 'pending',
            'attribute_combination' => json_encode($attributeCombination),
            'ip_address' => $request->ip(),
            'user_agent' => $parsed_user_agent, // حفظ النص القصير والمحلل هنا
            'order_code' => 'ORD-' . date('ym') . '-' . Str::upper(Str::random(6)),
            'coupon_code' => $validatedData['coupon_code'] ?? null,
            'discount_value' => $validatedData['discount_value'] ?? 0,
            'device_type' => $deviceType,
            'product_variation_id' => $validatedData['product_variation_id'],
        ]);

        // --- بداية الإضافة الجديدة ---
        // قم باستدعاء سيرفس التوزيع لتعيين الطلب الجديد تلقائياً
        OrderDistributionService::assignOrderToNextConfirmer($order);
        // --- نهاية الإضافة الجديدة ---

        ExportOrderToGoogleSheet::dispatch($order);

        return to_route('thankyou', ['order_code' => $order->order_code]);
    }

    public function show(CustomerOrders $customer_order)
    {
        return view('customer_orders.show', compact('customer_order'));
    }

    public function edit(CustomerOrders $customer_order)
    {
        return view('customer_orders.edit', compact('customer_order'));
    }

    /**
     * تحديث حالة الطلب
     * ✨ --- تم تعديل هذه الدالة --- ✨
     */
    public function update(Request $request, CustomerOrders $customer_order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $oldStatus = $customer_order->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return to_route('customer-orders.index')->with('info', 'لم يتم تغيير حالة الطلب.');
        }

        try {
            DB::transaction(function () use ($customer_order, $oldStatus, $newStatus) {

                $variation = $customer_order->productVariation;

                if ($newStatus === 'delivered' && $oldStatus !== 'delivered') {
                    if ($variation) {
                        $variation->decrement('quantity', $customer_order->quantity);
                        $variation->product->decrement('quantity', $customer_order->quantity);
                    } else {
                        $customer_order->product->decrement('quantity', $customer_order->quantity);
                    }
                    $customer_order->delivered_at = now();
                } elseif ($oldStatus === 'delivered' && $newStatus !== 'delivered') {
                    if ($variation) {
                        $variation->increment('quantity', $customer_order->quantity);
                        $variation->product->increment('quantity', $customer_order->quantity);
                    } else {
                        $customer_order->product->increment('quantity', $customer_order->quantity);
                    }
                    $customer_order->delivered_at = null;
                }

                // --- هذا المنطق يبقى كما هو لأنه يسجل هوية من قام بالإجراء الفعلي ---
                // هذا هو ما يضمن دقة حساب العمولات
                if (is_null($customer_order->confirmer_id) && in_array($newStatus, ['confirmed', 'cancelled_store', 'cancelled_customer'])) {
                    $customer_order->confirmer_id = auth()->id();
                    $customer_order->confirmation_action_at = now();
                }

                // تحديث حالة الطلب نفسه
                $customer_order->status = $newStatus;
                $customer_order->save();
            });

            return to_route('customer-orders.index')->with('success', 'تم تحديث الطلب والمخزون بنجاح.');
        } catch (Exception $e) {
            Log::error('فشل تحديث الطلب والمخزون: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ غير متوقع. لم يتم حفظ التغييرات.');
        }
    }

    public function destroy(CustomerOrders $customer_order)
    {
        $customer_order->delete();
        return redirect()->route('customer-orders.index');
    }

    public function thankyou($order_code)
    {
        $order = CustomerOrders::where('order_code', $order_code)->with('product')->firstOrFail();
        return view('thankyou', compact('order'));
    }

    public function bulkShip(Request $request, ShippingServiceInterface $shippingService)
    {
        if (!$shippingService) {
            return back()->with('error', 'لا توجد شركة شحن مفعلة حالياً. يرجى تفعيل واحدة أولاً.');
        }

        $validated = $request->validate([
            'order_ids'   => 'required|array',
            'order_ids.*' => 'exists:customer_orders,id',
        ]);

        $orders = CustomerOrders::with(['product', 'state', 'municipality'])->whereIn('id', $validated['order_ids'])->get();

        $successes = [];
        $failures = [];
        $skipped = [];

        foreach ($orders as $order) {
            if (in_array($order->status, ['confirmed', 'processing']) && is_null($order->tracking_number)) {
                $shipmentData = [
                    'order_id'              => $order->order_code,
                    'customer_name'         => $order->fullname,
                    'customer_phone'        => $order->phone,
                    'customer_address'      => $order->address,
                    'customer_commune_name' => $order->municipality->name_fr,
                    'customer_wilaya_id'    => $order->state->state_id,
                    'order_total'           => $order->total_price,
                    'products_string'       => optional($order->product)->name . ' (x' . $order->quantity . ')',
                ];

                $response = $shippingService->createShipment($shipmentData);

                if ($response['success']) {
                    $order->update([
                        'status' => 'shipped',
                        'tracking_number' => $response['tracking_number']
                    ]);
                    $successes[] = $order->id;
                } else {
                    $failures[] = [
                        'id' => $order->id,
                        'order_code' => $order->order_code,
                        'reason' => $response['message']
                    ];
                }
            } else {
                $skipped[] = $order->id;
            }
        }

        if (count($failures) > 0) {
            $errorMessages = "فشل شحن " . count($failures) . " طلبات للأسباب التالية:<br>";
            foreach ($failures as $failure) {
                $errorMessages .= " - الطلب رقم <strong>{$failure['order_code']}</strong>: " . $failure['reason'] . "<br>";
            }
            session()->flash('error', $errorMessages);
        }

        if(count($successes) > 0) {
            session()->flash('success', "تم شحن " . count($successes) . " طلبات بنجاح.");
        }

        if(count($skipped) > 0) {
            session()->flash('info', "تم تخطي " . count($skipped) . " طلبات (الحالة غير مناسبة أو تم شحنها مسبقاً).");
        }

        return back();
    }
    public function printLabel(CustomerOrders $order, ShippingServiceInterface $shippingService)
    {
        if (is_null($order->tracking_number)) {
            return back()->with('error', 'هذا الطلب لا يحتوي على رقم تتبع بعد.');
        }

        if (!$shippingService) {
            return back()->with('error', 'لا توجد شركة شحن مفعلة حالياً.');
        }

        $response = $shippingService->getOrderLabel($order->tracking_number);

        if (isset($response['success']) && $response['success']) {
            // إذا كان الرد هو محتوى PDF
            if ($response['type'] === 'pdf_content') {
                return response($response['data'], 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $response['filename'] . '"',
                ]);
            }
            // إذا كان الرد هو رابط مباشر
            elseif ($response['type'] === 'url') {
                return redirect()->away($response['data']);
            }
        }

        return back()->with('error', 'فشلت عملية جلب الفاتورة: ' . ($response['message'] ?? 'خطأ غير معروف.'));
    }

}
