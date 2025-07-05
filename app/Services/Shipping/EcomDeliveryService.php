<?php

namespace App\Services\Shipping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcomDeliveryService implements ShippingServiceInterface
{
    protected $apiKey;
    protected $baseUrl = ''; // أدخل الرابط الصحيح هنا

    public function __construct(array $settings)
    {
        $this->apiKey = $settings['api_key'] ?? null;
    }

    public function createShipment(array $data): array
    {
        // هذا الكلاس هو مجرد هيكل.
        // يجب الحصول على وثائق الـ API من شركة E-com Delivery لملء هذه البيانات.
        $payload = [
            // 'api_key' => $this->apiKey,
            // 'customer_name' => $data['fullname'],
            // ...
        ];

        throw new \Exception('خدمة شحن E-com Delivery غير مبرمجة بعد. يرجى إكمال الكود.');

        // $response = Http::post($this->baseUrl . 'createOrder', $payload);
        // if ($response->failed()) { ... }
        // return ['tracking_number' => $response->json(...)];
    }

    public function calculateFees(array $data): float { return 0.0; }
    public function trackShipment(string $trackingNumber): array { return []; }
}
