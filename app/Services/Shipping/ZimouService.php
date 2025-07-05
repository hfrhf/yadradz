<?php
namespace App\Services\Shipping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZimouService implements ShippingServiceInterface
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
        // يجب الحصول على وثائق الـ API من شركة Zimou Express لملء هذه البيانات.
        $payload = [
            // 'token' => $this->apiToken,
            // 'recipient_phone' => $data['phone'],
            // ...
        ];

        throw new \Exception('خدمة شحن Zimou Express غير مبرمجة بعد. يرجى إكمال الكود.');

        // $response = Http::withToken($this->apiToken)->post($this->baseUrl . 'new_shipment', $payload);
        // if ($response->failed()) { ... }
        // return ['tracking_number' => $response->json(...)];
    }

    public function calculateFees(array $data): float { return 0.0; }
    public function trackShipment(string $trackingNumber): array { return []; }
}