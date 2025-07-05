<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SetStoreLocale
{
    public function handle($request, Closure $next)
    {
        // استخدام الكاش لتقليل الوصول لقاعدة البيانات
        $language = Cache::rememberForever('store_language', function () {
            return DB::table('settings')->value('language') ?? 'ar'; // اللغة الافتراضية
        });

        App::setLocale($language); // تفعيل اللغة المختارة

        return $next($request);
    }
}
