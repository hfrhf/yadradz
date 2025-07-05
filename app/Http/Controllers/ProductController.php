<?php

namespace App\Http\Controllers;


use Image;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Traits\PermissionMiddlewareTrait;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PermissionMiddlewareTrait;
    public function __construct()
    {

        $this->applyPermissionMiddleware('product'); // أو 'order' أو 'category' حسب الحاجة
    }




    public function index()
    {

        $products=Product::query()->latest()->with('category')->paginate(7);
        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all() ;

        $allAttributes = Attribute::all(); // ✅ جلب جميع الخصائص
        $update=false;
        $product=new Product();
        return view('product.create',compact('product','update','categories','allAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // الحصول على البيانات من الطلب
        $form = $request->validated();
        $form['is_active'] = $request->has('is_active');

        // التحقق من وجود ملف صورة رئيسية وتخزينه
        if ($request->hasFile('image')) {
            // create new manager instance with desired driver
           $manager = new ImageManager(new Driver());
            // الحصول على الصورة
            $image = $request->file('image');

            // تحميل الصورة باستخدام Intervention Image
            $img = $manager->read($image);
            $img->resizedown(1200,800);
            $img->toWebp(100);

            $filename = Str::uuid() . '.webp';

            // مسار التخزين في مجلد التخزين العام
            $path = public_path('storage/product/' . $filename);

            // حفظ الصورة إلى المسار المحدد
            $img->save($path);

            $form['image'] = 'product/' . $filename;
        }

        // إنشاء المنتج وتخزينه في قاعدة البيانات
        $product = Product::create($form);
        $product->attributes()->sync($request->input('attributes', []));


        // التحقق من وجود ملفات متعددة (إذا كانت موجودة) وتخزينها
        if ($request->has('file_path')) {
            $filePath = $request->input('file_path'); // استرجاع مسار الملف من Dropzone
            $product->file_path = $filePath; // تعيين مسار الملف
            $product->save();
        }

       // التعامل مع الصور الإضافية
     if ($request->hasFile('images')) {
     foreach ($request->file('images') as $image) {
        // تحميل الصورة باستخدام Intervention Image

        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        // تغيير حجم الصورة
        $img->resizeDown(1800, 1400);
        $img->toWebp(100);
        // إنشاء اسم فريد للصورة مع الامتداد الصحيح
        $filename = Str::uuid() . '.webp';

        // مسار التخزين في مجلد التخزين العام
        $imagePath = 'product_images/' . $filename;
        $fullImagePath = public_path('storage/' . $imagePath);

        // حفظ الصورة إلى المسار المحدد
        $img->save($fullImagePath);

        // تخزين مسار الصورة النسبي في قاعدة البيانات
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,  // حفظ المسار النسبي في قاعدة البيانات
        ]);
     }
     }

          Cache::forget("products_index");
       Cache::forget("top_selling_products");
        Cache::forget("categories_with_products");
        // توجيه المستخدم مع رسالة نجاح
        return to_route('product.index')->with('success', 'Your product has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // --- الخطوة 1: حساب الإحصائيات الإجمالية للمنتج ---

        // استخدام استعلامات مباشرة على قاعدة البيانات لتحسين الأداء
        $totalOrders = $product->customerOrders()->count();
        $deliveredCount = $product->customerOrders()->where('status', 'delivered')->count();
        $returnedCount = $product->customerOrders()->where('status', 'returned')->count();
        $pendingCount = $totalOrders - ($deliveredCount + $returnedCount); // حساب الطلبات قيد الانتظار

        // حساب النسب المئوية مع التحقق من عدم القسمة على صفر
        $deliveredPercentage = ($totalOrders > 0) ? ($deliveredCount / $totalOrders) * 100 : 0;
        $returnedPercentage = ($totalOrders > 0) ? ($returnedCount / $totalOrders) * 100 : 0;
        $pendingPercentage = ($totalOrders > 0) ? ($pendingCount / $totalOrders) * 100 : 0;


        // --- الخطوة 2: تجهيز بيانات الرسم البياني للطلبات المسلمة (آخر 30 يومًا) ---

        $endDate = Carbon::today()->endOfDay();
        $startDate = Carbon::today()->subDays(29)->startOfDay();

        // جلب عدد الطلبات المسلمة يوميًا لهذا المنتج
        $ordersTrendData = $product->customerOrders()
            ->where('status', 'delivered')
            ->whereBetween('delivered_at', [$startDate, $endDate])
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw("DATE_FORMAT(delivered_at, '%Y-%m-%d') as date")
            )
            ->groupBy('date')
            ->orderBy('date', 'asc') // ترتيب حسب التاريخ
            ->get()
            ->keyBy('date');

        // إنشاء نطاق التواريخ الكامل لآخر 30 يومًا
        $dateRange = collect(Carbon::parse($startDate)->toPeriod($endDate))->map(function ($date) {
            return $date->format('Y-m-d');
        });

        // ملء البيانات للرسم البياني
        $ordersTrend = $dateRange->map(function ($date) use ($ordersTrendData) {
            return $ordersTrendData->get($date)->count ?? 0;
        });

        // --- الخطوة 3: تمرير البيانات إلى الـ view ---
        return view('product.show', [
            'product' => $product,
            'stats' => [
                'totalOrders' => $totalOrders,
                'deliveredCount' => $deliveredCount,
                'returnedCount' => $returnedCount,
                'pendingCount' => $pendingCount,
                'deliveredPercentage' => $deliveredPercentage,
                'returnedPercentage' => $returnedPercentage,
                'pendingPercentage' => $pendingPercentage,
            ],
            'chartData' => [
                'labels' => $dateRange,
                'values' => $ordersTrend,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
       // $product=new Product();
       $allAttributes = Attribute::all(); // ✅ جلب جميع الخصائص
       $categories=Category::all() ;
       $update=true;
        return view('product.edit',compact('product','update','categories','allAttributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
{
    // التحقق من صحة البيانات
    $form = $request->validated();
    $form['is_active'] = $request->has('is_active');

    // التحقق من وجود ملف الصورة الأساسية وتحديثه
    if ($request->hasFile('image')) {
        // حذف الصورة القديمة من التخزين
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // تحميل الصورة الجديدة باستخدام Intervention Image
        $image = $request->file('image');
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);

        $img->resizedown(1200, 800);
        $img->toWebp(100);
        $filename = Str::uuid() . '.webp';
        $form['image'] = 'product/' . $filename;
        $path = public_path('storage/' . $form['image']);
        $img->save($path);
    }

    // التحقق من وجود ملف جديد (من Dropzone) وتحديثه
    if ($request->has('file_path')) {
        // حذف الملف القديم من التخزين إذا كان موجودًا
        if ($product->file_path) {
            $oldFilePath = str_replace('/storage/', '', $product->file_path);
            if (Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }
        }

        // حفظ الملف الجديد
        $newFilePath = $request->input('file_path');
        $product->file_path = $newFilePath;
    }

    // تحديث المنتج بالبيانات الأساسية من النموذج
    $product->fill($form)->save();

    // مزامنة الخصائص
    $product->attributes()->sync($request->input('attributes', []));


    // ==========================================================
    // ==      بداية الجزء المضاف لإعادة تعيين علم الإشعار      ==
    // ==========================================================

    // تحديد حد المخزون المنخفض (يجب أن يكون نفس الرقم المستخدم في الأمر)
    $lowStockThreshold = 10;

    // التحقق مما إذا كانت الكمية الجديدة أكبر من الحد الأدنى
    // وما إذا كان قد تم إرسال إشعار سابقاً لهذا المنتج
    if ($product->quantity > $lowStockThreshold && $product->low_stock_notified) {
        // إعادة تعيين العلم إلى false للسماح بإرسال إشعارات مستقبلية
        $product->update(['low_stock_notified' => false]);
    }

    // ==========================================================
    // ==       نهاية الجزء المضاف لإعادة تعيين علم الإشعار      ==
    // ==========================================================


    // التحقق من وجود صور متعددة وحذف الصور القديمة
    if ($request->has('images')) {
        // حذف جميع الصور القديمة المرتبطة بالمنتج
        foreach ($product->images as $oldImage) {
            Storage::disk('public')->delete($oldImage->image_path);
            $oldImage->delete();
        }

        // إضافة الصور الجديدة
        foreach ($request->file('images') as $image) {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resizeDown(1800, 1400);
            $img->toWebp(100);
            $filename = Str::uuid() . '.webp';
            $imagePath = 'product_images/' . $filename;
            $fullImagePath = public_path('storage/' . $imagePath);
            $img->save($fullImagePath);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
            ]);
        }
    }

    // مسح الكاش وتوجيه المستخدم
    Cache::forget("products_index");
    Cache::forget("top_selling_products");
    Cache::forget("categories_with_products");
    return to_route('product.index')->with('success', 'Your product has been updated');
}



    /**
     * Remove the specified resource from storage.
     */
/**
 * Remove the specified resource from storage.
 */
public function destroy(Product $product)
{
    // حذف الصورة الرئيسية من التخزين إذا كانت موجودة
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }
    if ($product->images) {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
    }
    if ($product->file_path) {
        // إزالة "/storage/" من بداية المسار
        $filePath = str_replace('/storage/', '', $product->file_path);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        } else {
            Log::warning('File not found');
        }
    }




    // حذف المنتج من قاعدة البيانات
    $product->delete();
        Cache::forget("products_index");
    Cache::forget("top_selling_products");
    Cache::forget("categories_with_products");
    Cache::forget("top_selling_products");
    Cache::forget("categories_with_products");
    return to_route('product.index')->with('success', 'Your product has been deleted');
}

}
