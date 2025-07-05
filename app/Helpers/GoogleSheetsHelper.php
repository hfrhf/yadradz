<?php

namespace App\Helpers;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use App\Models\GoogleSheet;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class GoogleSheetsHelper
{
    public static function exportOrder($order)
    {
        try {
            // نحصل على أول إعداد فقط (لأنه إعداد وحيد)
            $setting = GoogleSheet::first();
            if (!$setting) {
                Log::warning('لا يوجد إعداد Google Sheets.');
                return;
            }

            $json = Crypt::decryptString($setting->service_account_json);
            $authConfig = json_decode($json, true);

            $client = new Google_Client();
            $client->setAuthConfig($authConfig);
            $client->addScope(Google_Service_Sheets::SPREADSHEETS);

            $service = new Google_Service_Sheets($client);

            $spreadsheetId = $setting->spreadsheet_id;
            $range = $setting->sheet_name . '!A1';

            // التحقق إن كانت الورقة فارغة
            $existing = $service->spreadsheets_values->get($spreadsheetId, $range);
            $rows = $existing->getValues();

            if (empty($rows)) {
                $headers = [[
                    'كود الطلب',
                    'الاسم الكامل',
                    'رقم الهاتف',
                    'اسم المنتج',
                    'الكمية',
                    'السعر الإجمالي',
                    'تاريخ الطلب',
                ]];

                $headerBody = new Google_Service_Sheets_ValueRange(['values' => $headers]);
                $params = ['valueInputOption' => 'USER_ENTERED'];
                $service->spreadsheets_values->append($spreadsheetId, $range, $headerBody, $params);
            }

            $values = [[
                $order->order_code,
                $order->fullname,
                $order->phone,
                optional($order->product)->name ?? '',
                $order->quantity,
                $order->total_price,
                now()->toDateTimeString(),
            ]];

            $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];
            $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

        } catch (\Exception $e) {
            Log::error('خطأ في تصدير الطلب إلى Google Sheets: ' . $e->getMessage());
        }
    }
}
