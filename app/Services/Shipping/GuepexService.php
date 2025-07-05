<?php
namespace App\Services\Shipping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GuepexService implements ShippingServiceInterface
{
    protected $apiToken;
    protected $baseUrl = ''; // أدخل الرابط الصحيح هنا

    public function __construct(array $settings)
    {
        $this->apiToken = $settings['api_token'] ?? null;
    }

    public function createShipment(array $data): array
    {
        // هذا الكلاس هو مجرد هيكل.
        // يجب الحصول على وثائق الـ API من شركة Guepex لملء هذه البيانات.
        $payload = [
            // 'api_token' => $this->apiToken,
            // 'order_ref' => $data['order_id'],
            // ...
        ];

        throw new \Exception('خدمة شحن Guepex غير مبرمجة بعد. يرجى إكمال الكود.');

        // $response = Http::post($this->baseUrl . 'shipment', $payload);
        // if ($response->failed()) { ... }
        // return ['tracking_number' => $response->json(...)];
    }

    public function calculateFees(array $data): float { return 0.0; }
    public function trackShipment(string $trackingNumber): array { return []; }
}
