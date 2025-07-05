<?php

namespace App\Http\Controllers;

use App\Models\Visits;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shipping;
use App\Models\AdminInfo;
use App\Models\Attribute;
use Illuminate\Support\Str;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class StoreController extends Controller
{



    public function index(Request $request)
{
    // تخزين واسترجاع المنتجات الأكثر مبيعًا في الكاش
    $topSellingProducts = Cache::remember('top_selling_products', 3600, function () {
        return Product::active()->orderBy('sales_count', 'desc')
            ->take(4)
            ->get();
    });

    // تخزين واسترجاع الفئات في الكاش
    $categories = Cache::remember('categories_with_products', 3600, function () {
        return Category::with('product')->has('product')->get();
    });

    $name = $request->input('name');
    $categoriesIds = $request->input('categories');
    $max = $request->input('max');
    $min = $request->input('min');

    $productsQuery = Product::query()->active();

    // تطبيق الفلاتر بشكل مشروط
    $productsQuery->when($name, function ($query, $name) {
        return $query->where(function ($q) use ($name) {
            $q->where('name', 'like', "%{$name}%")
                ->orWhere('description', 'like', "%{$name}%");
        });
    });

    $productsQuery->when($categoriesIds, function ($query, $categoriesIds) {
        return $query->whereIn('category_id', $categoriesIds);
    });

    $productsQuery->when($max, function ($query, $max) {
        return $query->where('price', '<=', $max);
    });

    $productsQuery->when($min, function ($query, $min) {
        return $query->where('price', '>=', $min);
    });

    // إذا لم يتم تطبيق أي فلاتر، قم بترتيب المنتجات حسب الأحدث وتخزينها في الكاش
    if (!$name && !$categoriesIds && !$max && !$min) {
        // استخدام الكاش مع جلب البيانات بدون pagination
        $products = Cache::remember("products_index", 3600, function () use ($productsQuery) {
            return $productsQuery->latest()->get();
        });

        // تطبيق paginate على البيانات المخزنة في الكاش
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $products->forPage(request('page', 1), 9), // تقسيم النتائج حسب الصفحة
            $products->count(), // العدد الكلي للنتائج
            9, // عدد العناصر في كل صفحة
            request('page', 1), // رقم الصفحة الحالية
            ['path' => request()->url(), 'query' => request()->query()] // إعداد رابط pagination
        );
    } else {
        // عدم تخزين النتائج المفلترة في الكاش
        $products = $productsQuery->latest()->paginate(9);
    }


    $ipAddress = $request->ip();
    $today = now()->toDateString();

    $exists = Visits::where('ip_address', $ipAddress)
        ->whereDate('visited_at', $today) // مقارنة التاريخ فقط
        ->exists();


    if (!$exists) {
        Visits::create([
            'ip_address' => $ipAddress,
            'url' => $request->fullUrl(),
            'visited_at' => now(),
        ]);
    }

    return view('store.index', compact('products', 'categories', 'topSellingProducts'));
}










public function show(Product $product, Request $request)
{
    // تعريف معرف فريد للجلسة أو المستخدم
    $userIdentifier = auth()->check() ? auth()->id() : $request->cookie('device_id') ?? Str::uuid();
    $month = now()->format('Y-m'); // استخدام `now()` للحصول على تاريخ الوقت الحالي
    $cookieName = 'product_viewed_' . $product->id . '_' . $userIdentifier . '_' . $month;

    // التحقق من وجود الكوكيز
    if (!$request->hasCookie($cookieName)) {
        // زيادة عدد المشاهدات
        $product->increment('views');

        // ضبط الكوكيز للمستخدم الحالي فقط
        // يتم ضبط `device_id` فقط إذا كان غير موجود
        if (!$request->cookie('device_id')) {
            Cookie::queue('device_id', $userIdentifier, 60 * 24 * 30);  // ضبط فترة زمنية معقولة
        }

        // ضبط كوكيز المشاهدة للمنتج
        Cookie::queue($cookieName, true, 60 * 24); // ضبط فترة زمنية معقولة (يوم واحد)
    }

    $shippings=Shipping::all();

$municipalities = Municipality::select('id', 'name', 'state_id','name_fr','is_delivery')->get();
    $attributes = $product->attributes;
    $productVariations  = ProductVariation::with('attributeValues')->where('product_id', $product->id)->get();




    // تمرير المنتج للعرض في الواجهة الأمامية
    return view('store.show', compact('product','shippings','attributes','productVariations','municipalities'));
}
public function contact()
{
    // جلب أول سجل لمعلومات الإدارة
    $adminInfo = AdminInfo::first();

    // في حال عدم وجود بيانات، نستخدم بيانات افتراضية
    if (!$adminInfo) {
        $adminInfo = new AdminInfo([
            'facebook' => '#',
            'email'    => 'contact@example.com',
            'twitter'  => '#',
            'phone'    => '000-000-0000',
        ]);
    }

    // عرض الصفحة مع تمرير البيانات إليها
    return view('store.contact', compact('adminInfo'));
}
}
