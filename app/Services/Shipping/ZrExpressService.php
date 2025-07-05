<?php

namespace App\Services\Shipping;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZrExpressService implements ShippingServiceInterface
{
    /**
     * The API key provided by ZR Express.
     * @var string|null
     */
    protected $apiKey;

    /**
     * The API token provided by ZR Express.
     * @var string|null
     */
    protected $apiToken;

    /**
     * The base URL for the ZR Express API.
     * @var string
     */
    protected $baseUrl = 'https://procolis.com/api_v1';

    /**
     * Constructor to initialize the service with settings from the database.
     */
    public function __construct(array $settings)
    {
        $this->apiKey = $settings['api_id'] ?? null;      // "key" from docs
        $this->apiToken = $settings['api_token'] ?? null; // "token" from docs
    }

    /**
     * Create a new shipment manually.
     */
    public function createShipment(array $data): array
    {
        if (!$this->apiKey || !$this->apiToken) {
            return [
                'success' => false,
                'message' => 'بيانات الدخول (API Key or Token) لشركة ZR Express غير موجودة.',
                'tracking_number' => null,
            ];
        }

        try {
            $payload = [
                "Client"        => $data['customer_name'],
                "MobileA"       => $data['customer_phone'],
                "Adresse"       => $data['customer_address'],
                "Commune"       => $data['customer_commune_name'],
                "IDWilaya"      => (string)$data['customer_wilaya_id'],
                "Total"         => (string)$data['order_total'],
                "TProduit"      => $data['products_string'],
                "id_Externe"    => $data['order_id'],
                "Tracking"      => $data['order_id'],
                "TypeLivraison" => "0",
                "TypeColis"     => "0",
                "Confrimee"     => "1",
                "Note"          => "",
                "Source"        => "MonMagasin",
            ];

            $response = Http::withHeaders([
                'key'   => $this->apiKey,
                'token' => $this->apiToken,
            ])->post($this->baseUrl . '/add_colis', ["Colis" => [$payload]]);

            if ($response->successful()) {
                $responseData = $response->json();

                // ✅ تم التصحيح هنا: التحقق من بنية الرد الصحيحة
                if (isset($responseData['Colis'][0])) {
                    $colisResponse = $responseData['Colis'][0];

                    // التحقق من كود الرد من الـ API. "0" يعني نجاح
                    if (isset($colisResponse['IDRetour']) && $colisResponse['IDRetour'] === '0') {
                         return [
                            'success' => true,
                            'tracking_number' => $colisResponse['Tracking'] ?? null,
                            'message' => 'تم إنشاء الشحنة بنجاح مع ZR Express.'
                        ];
                    }

                    // إذا لم يكن IDRetour هو "0"، فهذا خطأ من الـ API
                    $errorMessage = $colisResponse['MessageRetour'] ?? json_encode($responseData);
                    Log::error('ZR Express API Handled Error: ' . $errorMessage);
                    return [
                        'success' => false,
                        'tracking_number' => null,
                        'message' => 'خطأ من ZR Express API: ' . $errorMessage
                    ];
                }

                 // إذا لم تكن بنية الرد متوقعة
                Log::error('ZR Express API Invalid Response Structure: ' . $response->body());
                return [
                    'success' => false,
                    'tracking_number' => null,
                    'message' => 'رد غير متوقع من خادم ZR Express: ' . $response->body()
                ];
            }

            // في حالة فشل الاتصال
            Log::error('ZR Express API HTTP Error: ' . $response->body());
            return [
                'success' => false,
                'tracking_number' => null,
                'message' => 'فشل إنشاء الشحنة. الرد من الخادم: ' . ($response->json()['message'] ?? $response->body())
            ];

        } catch (Exception $e) {
            Log::error('ZR Express Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'tracking_number' => null,
                'message' => 'حدث خطأ تقني أثناء الاتصال بـ ZR Express.'
            ];
        }
    }

    /**
     * Calculate shipping fees manually.
     */
    public function calculateFees(array $data): float
    {
        try {
             // استخدام نقطة النهاية الصحيحة للتسعير
             $response = Http::withHeaders([
                'key'   => $this->apiKey,
                'token' => $this->apiToken,
             ])->post($this->baseUrl . '/tarification', [
                'wilaya_id_dest' => $data['customer_wilaya_id']
             ]);

             if ($response->successful()) {
                return (float) ($response->json()['montant'] ?? 600.0);
             }
             return 600.0;
        } catch (Exception $e) {
            return 650.0;
        }
    }

    /**
     * Track a shipment.
     */
    public function trackShipment(string $trackingNumber): array
    {
        // هذه الدالة تحتاج لنقطة النهاية الخاصة بالتتبع (مثل /lire)
        return [
            'success' => false,
            'status' => 'Not Implemented',
            'message' => 'خاصية التتبع لم تنفذ بعد لهذه الشركة.'
        ];
    }
    public function getOrderLabel(string $trackingNumber): array
    {
        // ✅ تم التعديل هنا: إرجاع رسالة واضحة للمستخدم
        return [
            'success' => false,
            'message' => "La fonctionnalité d'impression n'est pas encore configurée pour ZR Express. Veuillez contacter leur support pour obtenir l'endpoint correct de l'API pour les étiquettes, puis nous pourrons finaliser l'intégration."
        ];
    }
}
