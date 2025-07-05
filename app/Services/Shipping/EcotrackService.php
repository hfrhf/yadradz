<?php

namespace App\Services\Shipping;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcotrackService implements ShippingServiceInterface
{
    /**
     * The API token provided by Ecotrack.
     * @var string|null
     */
    protected $apiToken;

    /**
     * The base URL for the specific Ecotrack platform (e.g., world-express.ecotrack.dz).
     * @var string|null
     */
    protected $platformUrl;

    /**
     * Constructor to initialize the service with dynamic settings.
     */
    public function __construct(array $settings)
    {
        $this->apiToken = $settings['api_token'] ?? null;
        // ✅ تم التعديل هنا: قراءة الرابط من الإعدادات بدلاً من كونه ثابتاً
        $this->platformUrl = $settings['platform_url'] ?? null;
    }

    /**
     * Create a new shipment.
     */
    public function createShipment(array $data): array
    {
        // التحقق من وجود البيانات الأساسية
        if (!$this->apiToken || !$this->platformUrl) {
            return [
                'success' => false,
                'message' => 'API Token أو رابط المنصة (Platform URL) غير موجود في الإعدادات.',
                'tracking_number' => null,
            ];
        }

        try {
            $payload = [
                'reference'     => $data['order_id'],
                'nom_client'    => $data['customer_name'],
                'telephone'     => $data['customer_phone'],
                'adresse'       => $data['customer_address'],
                'commune'       => $data['customer_commune_name'],
                'code_wilaya'   => $data['customer_wilaya_id'],
                'montant'       => $data['order_total'],
                'produit'       => $data['products_string'],
                'type'          => 1, // 1 = Livraison standard
                'stop_desk'     => 0, // 0 = à domicile
            ];

            // ✅ بناء الرابط الكامل ديناميكياً
            $fullUrl = rtrim($this->platformUrl, '/') . '/api/v1/create/order';
            $requestUrl = $fullUrl . '?' . http_build_query($payload);

            $response = Http::withToken($this->apiToken)
                ->post($requestUrl);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['success']) && $responseData['success'] === true) {
                     return [
                        'success' => true,
                        'tracking_number' => $responseData['tracking'] ?? null,
                        'message' => 'تم إنشاء الطلب بنجاح عبر Ecotrack.'
                    ];
                }

                $errorMessage = $responseData['message'] ?? json_encode($responseData);
                Log::error('Ecotrack API Handled Error: ' . $errorMessage);
                return [
                    'success' => false,
                    'tracking_number' => null,
                    'message' => 'خطأ من API الخاص بـ Ecotrack: ' . $errorMessage
                ];
            }

            Log::error('Ecotrack API HTTP Error: ' . $response->body());
            return [
                'success' => false,
                'tracking_number' => null,
                'message' => 'فشل إنشاء الطلب. الرد من الخادم: ' . ($response->json()['message'] ?? $response->body())
            ];

        } catch (Exception $e) {
            Log::error('Ecotrack Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'tracking_number' => null,
                'message' => 'حدث خطأ تقني أثناء الاتصال بـ Ecotrack.'
            ];
        }
    }

    /**
     * Calculate shipping fees.
     */
    public function calculateFees(array $data): float
    {
        return 600.0;
    }

    /**
     * Track a shipment.
     */
    public function trackShipment(string $trackingNumber): array
    {
        if (!$this->apiToken || !$this->platformUrl) {
            return ['success' => false, 'status' => 'خطأ في الإعدادات', 'message' => 'API Token أو رابط المنصة غير موجود.'];
        }

        try {
            $fullUrl = rtrim($this->platformUrl, '/') . '/api/v1/get/tracking/info';
            $response = Http::withToken($this->apiToken)
                ->get($fullUrl, ['tracking' => $trackingNumber]);

            if ($response->successful()) {
                $responseData = $response->json();
                return [
                    'success' => true,
                    'status'  => $responseData['activity'][count($responseData['activity']) - 1]['status'] ?? 'غير معروف',
                    'history' => $responseData['activity'] ?? [],
                ];
            }

            return ['success' => false, 'status' => 'غير موجود', 'message' => 'لا يمكن تتبع هذا الطرد.'];
        } catch (Exception $e) {
             return ['success' => false, 'status'  => 'خطأ', 'message' => 'حدث استثناء: ' . $e->getMessage()];
        }
    }
    public function getOrderLabel(string $trackingNumber): array
    {
        if (!$this->apiToken || !$this->platformUrl) {
            return ['success' => false, 'message' => 'API Token أو رابط المنصة غير موجود.'];
        }

        try {
            $fullUrl = rtrim($this->platformUrl, '/') . '/api/v1/get/order/label';

            $response = Http::withToken($this->apiToken)->get($fullUrl, [
                'tracking' => $trackingNumber,
            ]);

            if ($response->successful() && str_contains($response->header('Content-Type'), 'application/pdf')) {
                return [
                    'success'  => true,
                    'type'     => 'pdf_content',
                    'data'     => $response->body(),
                    'filename' => 'label-' . $trackingNumber . '.pdf'
                ];
            }

            return [
                'success' => false,
                'message' => 'لا يمكن جلب الفاتورة. الرد من الخادم: ' . $response->body()
            ];

        } catch (Exception $e) {
             return ['success' => false, 'message' => 'حدث استثناء: ' . $e->getMessage()];
        }
    }
}