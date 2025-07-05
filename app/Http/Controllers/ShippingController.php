<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\PermissionMiddlewareTrait;
use App\Http\Requests\StoreShippingRequest;
use App\Http\Requests\UpdateShippingRequest;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     use PermissionMiddlewareTrait;
     public function __construct()
     {

         $this->applyPermissionMiddleware('shippings'); // أو 'order' أو 'category' حسب الحاجة
     }
     public function index(): View
    {
        $shippingColumns = [
            'shippings.id',
            'shippings.state',
            'shippings.state_fr',
            'shippings.to_office_price',
            'shippings.to_home_price',
            'shippings.created_at',
            'shippings.updated_at',
            'shippings.state_id',
        ];
        $shippings = Shipping::query()
            ->leftJoin('customer_orders', 'shippings.id', '=', 'customer_orders.state_id')
            ->select(
                'shippings.*',
                DB::raw('SUM(CASE WHEN customer_orders.status = "delivered" THEN 1 ELSE 0 END) as total_orders'),
                DB::raw('COALESCE(ROUND(AVG(TIMESTAMPDIFF(HOUR, customer_orders.created_at, customer_orders.delivered_at)) / 24, 2), 0) as avg_delivery_days'),
                DB::raw('COALESCE(ROUND((SUM(CASE WHEN customer_orders.status = "returned" THEN 1 ELSE 0 END) * 100) / NULLIF(COUNT(customer_orders.id), 0), 2), 0) as return_rate')
            )
            ->groupBy($shippingColumns) // التجميع بناءً على معرّف الولاية لضمان دقة الإحصائيات
            ->get();

        // إرسال البيانات إلى الواجهة الأمامية (view)
        return view('shippings.index', compact('shippings'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shippings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShippingRequest $request)
    {
        Shipping::create($request->validated());
        return to_route('shippings.index')->with('success', 'تمت إضافة الولاية بنجاح.');
    }

    public function show(Shipping $shipping)
    {
        //
    }

    public function edit(Shipping $shipping)
    {
        return view('shippings.edit', compact("shipping"));
    }

    public function update(UpdateShippingRequest $request, Shipping $shipping)
    {
        $validated = $request->validated();

        // فصل بيانات الشحن عن بيانات البلديات
        $shippingData = collect($validated)->except('municipalities')->toArray();
        $shipping->update($shippingData);

        // تحديث بيانات is_delivery للبلديات
        $checkedMunicipalities = $validated['municipalities'] ?? [];

        foreach ($shipping->municipalities as $municipality) {
            $municipality->is_delivery = array_key_exists($municipality->id, $checkedMunicipalities);
            $municipality->save();
        }

        return redirect()->route('shippings.index')->with('success', 'تم تحديث بيانات الشحن بنجاح.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipping $shipping)
    {
        $shipping->delete();
        return back();
    }
}
