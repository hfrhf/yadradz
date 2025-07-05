<?php
namespace App\Providers;

use Exception;
use Carbon\Carbon;
use App\Models\Cart\Cart;
use App\Models\MarketingTracker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            try {
                // جلب جميع المتتبعات النشطة من قاعدة البيانات
                $trackers = MarketingTracker::where('is_active', true)->get();

                // تجميع المتتبعات حسب النوع (facebook, tiktok, etc.) لتسهيل استخدامها
                $groupedTrackers = $trackers->groupBy('type');

                // مشاركة المتغير مع جميع ملفات العرض (Views) في التطبيق
                View::share('activeTrackers', $groupedTrackers);
            } catch (Exception $e) {
                // في حالة وجود خطأ (مثل عدم وجود جدول)، نتجاهله لتجنب تعطل التطبيق
                // يمكنك تسجيل الخطأ هنا إذا أردت
                View::share('activeTrackers', collect()); // مشاركة مجموعة فارغة
            }
        }

        Paginator::useBootstrapFive();
        View::composer('*', function ($view) {
            $locale = App::getLocale();
            $direction = $locale === 'ar' ? 'rtl' : 'ltr';

            $view->with('currentLocale', $locale);
            $view->with('direction', $direction);
        });


        // Set the locale to Arabic
        Carbon::setLocale('ar');

        // Set the system locale to Arabic for date formatting
        setlocale(LC_TIME, 'ar');

        // Define a macro for translated date format
        Carbon::macro('translatedFormat', function ($format) {
            $months = [
                'January' => 'يناير',
                'February' => 'فبراير',
                'March' => 'مارس',
                'April' => 'أبريل',
                'May' => 'مايو',
                'June' => 'يونيو',
                'July' => 'يوليو',
                'August' => 'أغسطس',
                'September' => 'سبتمبر',
                'October' => 'أكتوبر',
                'November' => 'نوفمبر',
                'December' => 'ديسمبر',
            ];

            $formattedDate = $this->format($format);


            return str_replace(array_keys($months), array_values($months), $formattedDate);
        });

    }
}
