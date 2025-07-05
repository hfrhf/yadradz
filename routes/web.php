<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ThankYouController;
use App\Http\Controllers\AdminInfoController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\ConfirmerController;
use App\Http\Controllers\SiteColorController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CustomerOrdersController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\ShippingCompanyController;
use App\Http\Controllers\ConfirmerPaymentController;
use App\Http\Controllers\MarketingTrackerController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\GoogleSheetsSettingController;
use App\Http\Controllers\Payment\PaypalWithCardController;
use App\Http\Controllers\Payment\StripeWithCardController;
use App\Http\Controllers\Marketing\TiktokTrackerController;
use App\Http\Controllers\Marketing\FacebookTrackerController;
use App\Http\Controllers\Marketing\GoogleAnalyticsController;
use App\Http\Controllers\Marketing\GoogleTagManagerController;

// المسارات العامة التي لا تحتاج تسجيل دخول
Route::middleware(['store.locale'])->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('store');
    Route::get('/productStore/{product}', [StoreController::class, 'show'])->name('store.show');
    Route::get('/contact-us', [StoreController::class, 'contact'])->name('store.contact_us');
       // السلة
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('customer-orders', [CustomerOrdersController::class, 'store'])->name('customer-orders.store');
Route::get('/thank-you', [ThankYouController::class, 'index'])->name('thankyou');
});




// المسارات التي تتطلب auth فقط
Route::middleware(['auth'])->group(function () {
    Route::get('notifications/create', [AdminNotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications/send', [AdminNotificationController::class, 'send'])->name('notifications.send');


    Route::resource('shippings', ShippingController::class);
    Route::get('shipping-companies', [ShippingCompanyController::class, 'index'])->name('shippingcompany.index');
    Route::get('shipping-companies/{shippingCompany}/edit', [ShippingCompanyController::class, 'edit'])->name('shippingcompany.edit');
    Route::put('shipping-companies/{shippingCompany}', [ShippingCompanyController::class, 'update'])->name('shippingcompany.update');
    Route::post('shipping-companies/{shippingCompany}/activate', [ShippingCompanyController::class, 'activate'])->name('shippingcompany.activate');
    Route::post('shipping-companies/{shippingCompany}/deactivate', [ShippingCompanyController::class, 'deactivate'])->name('shippingcompany.deactivate');


// مسار لعرض لوحة تحكم لمؤكدين
    Route::get('confirmers', [ConfirmerController::class, 'index'])->name('confirmers.index');

    // مسار لمعالجة عملية تسجيل دفعة جديدة
    Route::post('confirmers/{user}/pay', [ConfirmerPaymentController::class, 'store'])->name('confirmers.pay');
    Route::get('confirmers/{user}/history', [ConfirmerController::class, 'history'])->name('confirmers.history');


    Route::resource('attributes', AttributeController::class);
    Route::resource('attribute-values', AttributeValueController::class);
    Route::resource('product-variations', ProductVariationController::class);

    Route::get('/google-sheets', [GoogleSheetController::class, 'index'])->name('google-sheets.index');
    Route::get('/google-sheets/create', [GoogleSheetController::class, 'create'])->name('google-sheets.create');
    Route::get('/google-sheets/edit', [GoogleSheetController::class, 'edit'])->name('google-sheets.edit');
    Route::put('/google-sheets', [GoogleSheetController::class, 'update'])->name('google-sheets.update');
    Route::post('/google-sheets', [GoogleSheetController::class, 'store'])->name('google-sheets.store');
    Route::delete('/google-sheets/{googleSheet}', [GoogleSheetController::class, 'destroy'])->name('google-sheets.destroy');
    //Route::post('/customer-orders/bulk-ship', [CustomerOrdersController::class, 'bulkShip'])->name('customer-orders.bulkShip');
    // قم بتغيير post إلى get مؤقتاً
    Route::post('/customer-orders/bulk-ship', [CustomerOrdersController::class, 'bulkShip'])->name('customer-orders.bulkShip');
    Route::get('/customer-orders/{order}/print-label', [CustomerOrdersController::class, 'printLabel'])->name('customer-orders.printLabel');
    Route::resource('customer-orders', CustomerOrdersController::class)->except(['store']);
    // في routes/web.php

    Route::resource('blacklist', BlacklistController::class);



    // المنتجات والملفات الشخصية
    Route::resource('product', ProductController::class);
    Route::resource('profile', ProfileController::class);

    // الصلاحيات والأدوار
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);

    // التصنيفات
    Route::resource('category', CategoryController::class);

    // التقارير
    Route::resource('reports', ReportsController::class);

    // الإعدادات
    Route::resource('settings', SettingController::class);
    Route::resource('colors', SiteColorController::class);

    // المبيعات
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

    // لوحة التحكم
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');

    // المعلومات الإدارية
    Route::resource('info', AdminInfoController::class);

    // المستخدم
    Route::resource('order', OrderController::class);


        // 🟢 تتبع التسويق: Facebook, TikTok, GA, GTM
    Route::resource('facebook', FacebookTrackerController::class)->except(['show']);
    Route::resource('tiktok', TiktokTrackerController::class)->except(['show']);
    Route::get('ga', [GoogleAnalyticsController::class, 'index'])->name('ga.index');
    Route::get('ga/create', [GoogleAnalyticsController::class, 'create'])->name('ga.create');
    Route::post('ga', [GoogleAnalyticsController::class, 'store'])->name('ga.store');
    Route::put('ga/{ga}', [GoogleAnalyticsController::class, 'update'])->name('ga.update');
    Route::get('gtm', [GoogleTagManagerController::class, 'index'])->name('gtm.index');
    Route::get('gtm/create', [GoogleTagManagerController::class, 'create'])->name('gtm.create');
    Route::post('gtm', [GoogleTagManagerController::class, 'store'])->name('gtm.store');
    Route::put('gtm/{gtm}', [GoogleTagManagerController::class, 'update'])->name('gtm.update');

});
// routes/web.php

// --- بداية مجموعة روابط الإشعارات ---
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
    Route::get('/user/notifications', function (Request $request) {
        $user = $request->user();

        return [
            // حافظنا على نفس الأسماء
            'unread' => $user->unreadNotifications()->limit(10)->get(), // جلب أحدث 10 إشعارات غير مقروءة
            'read'   => $user->readNotifications()->limit(5)->get(),   // جلب أحدث 5 إشعارات مقروءة
        ];
    });

    Route::post('/user/notifications/mark-as-read', function (Request $request) {
        $request->user()->unreadNotifications->markAsRead();
        return response()->noContent();
    });
});
// --- نهاية مجموعة روابط الإشعارات ---
// توثيق الحساب بالبريد غير مفعل الآن
Auth::routes(['register' => false, 'verify' => false, 'reset' => true]);

