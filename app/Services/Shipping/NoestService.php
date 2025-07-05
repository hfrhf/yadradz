<?php
namespace App\Services\Shipping;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NoestService implements ShippingServiceInterface
{
    protected $apiToken;
    protected $baseUrl = 'https://app.noest-dz.com/api/';

    public function __construct(array $settings)
    {
        $this->apiToken = $settings['api_token'] ?? null;
    }

    public function createShipment(array $data): array
    {
        $payload = [
            // جهز البيانات هنا حسب وثائق NOEST API
            // ...
        ];

        $response = Http::withToken($this->apiToken)
            ->post($this->baseUrl . 'orders', $payload);

        if ($response->failed()) {
            Log::error('NOEST API Error: ' . $response->body());
            throw new \Exception('فشل الاتصال بـ API نورد ويست. تفاصيل الخطأ: ' . $response->body());
        }

        return ['tracking_number' => $response->json('tracking_id')]; // مثال
    }

    public function calculateFees(array $data): float { return 0.0; }
    public function trackShipment(string $trackingNumber): array { return []; }
}