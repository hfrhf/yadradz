<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\SiteColor;

class LoadSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // استخدام الكاش لجلب الإعدادات
        $setting = Cache::remember('site_settings', 86400, function() {
            return Setting::first();
        });

        // استخدام الكاش لجلب ألوان الموقع
        $siteColors = Cache::remember('site_colors', 86400, function() {
            return SiteColor::first();
        });

        // تحديث اسم الموقع في إعدادات التطبيق إذا كان هناك إعدادات
        if ($setting) {
            Config::set('app.name', $setting->site_name);
        }

        // شارك الإعدادات مع جميع العروض (Views)
        View::share('setting', $setting);
        View::share('siteColors', $siteColors); // مشاركة ألوان الموقع مع العروض

        return $next($request);
    }
}
