<?php

namespace App\Providers;

use App\Models\ShippingCompany;
use App\Services\Shipping\NoestService;
use App\Services\Shipping\ZimouService;
use Illuminate\Support\ServiceProvider;
use App\Services\Shipping\GuepexService;
use App\Services\Shipping\MaystroService;
use App\Services\Shipping\EcotrackService;
use App\Services\Shipping\YalidineService;
use App\Services\Shipping\ZrExpressService;
use App\Services\Shipping\EcomDeliveryService;
use App\Services\Shipping\ShippingServiceInterface;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * مصفوفة لربط كل slug بالكلاس المناسب له
     * هذه هي الطريقة الأفضل للتعامل مع الحالات الخاصة مثل Ecotrack
     */
    protected $serviceMap = [
        'yalidine'        => YalidineService::class,
        'zr-express'      => ZrExpressService::class, // Procolis is ZR Express
        'ecotrack'        => EcotrackService::class,
        'maystro'         => MaystroService::class,
        'noest'         => NoestService::class,
        'guepex'        => GuepexService::class,
        'ecom-delivery' => EcomDeliveryService::class,
        'zimou'         => ZimouService::class,
    ];

    public function register()
    {
        $this->app->singleton(ShippingServiceInterface::class, function ($app) {
            try {
                $activeCompany = ShippingCompany::where('is_active', true)->first();
            } catch (\Exception $e) {
                return null;
            }

            if (!$activeCompany) {
                return null;
            }

            $slug = $activeCompany->slug;
            $settings = $activeCompany->settings ?? [];

            // تحقق إذا كان الـ slug موجوداً في الخريطة
            if (isset($this->serviceMap[$slug])) {
                $classPath = $this->serviceMap[$slug];

                // تأكد من أن الكلاس موجود قبل إنشاء نسخة منه
                if(class_exists($classPath)) {
                    return new $classPath($settings);
                }
            }

            return null; // لا يوجد تعريف لهذه الشركة
        });
    }
}