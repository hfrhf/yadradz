<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shipping; // تأكد من استدعاء الموديل الصحيح

class ShippingStateIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ تم التعديل هنا: استخدام مصفوفة ربط لضمان صحة الأكواد
        // هذه هي الطريقة الصحيحة لربط اسم الولاية بالكود الرسمي لها
        $wilayaMapping = [
            'Adrar' => 1, 'Chlef' => 2, 'Laghouat' => 3, 'Oum El Bouaghi' => 4, 'Batna' => 5,
            'Béjaïa' => 6, 'Biskra' => 7, 'Béchar' => 8, 'Blida' => 9, 'Bouira' => 10,
            'Tamanrasset' => 11, 'Tébessa' => 12, 'Tlemcen' => 13, 'Tiaret' => 14, 'Tizi Ouzou' => 15,
            'Alger' => 16, 'Djelfa' => 17, 'Jijel' => 18, 'Sétif' => 19, 'Saïda' => 20,
            'Skikda' => 21, 'Sidi Bel Abbès' => 22, 'Annaba' => 23, 'Guelma' => 24, 'Constantine' => 25,
            'Médéa' => 26, 'Mostaganem' => 27, 'M\'sila' => 28, // ✅ تم التعديل هنا
            'Mascara' => 29, 'Ouargla' => 30,
            'Oran' => 31, 'El Bayadh' => 32, 'Illizi' => 33, 'Bordj Bou Arréridj' => 34, // ✅ تم التعديل هنا
            'Boumerdès' => 35,
            'El Tarf' => 36, 'Tindouf' => 37, 'Tissemsilt' => 38, 'El Oued' => 39, 'Khenchela' => 40,
            'Souk Ahras' => 41, 'Tipaza' => 42, 'Mila' => 43, 'Aïn Defla' => 44, 'Naâma' => 45,
            'Aïn Témouchent' => 46, 'Ghardaïa' => 47, 'Relizane' => 48, 'Timimoun' => 49, 'Bordj Badji Mokhtar' => 50,
            'Ouled Djellal' => 51, 'Béni Abbès' => 52, 'In Salah' => 53, 'In Guezzam' => 54, 'Touggourt' => 55,
            'Djanet' => 56, 'El M\'ghair' => 57, 'El Meniaa' => 58
        ];

        $shippings = Shipping::all();
        $updatedCount = 0;
        $notFound = [];

        $this->command->info('Starting to update state_id for ' . $shippings->count() . ' records...');

        foreach ($shippings as $shipping) {
            // البحث عن اسم الولاية الفرنسي في مصفوفة الربط
            if (isset($wilayaMapping[$shipping->state_fr])) {
                $correctStateId = $wilayaMapping[$shipping->state_fr];

                // تحديث السجل فقط إذا كانت القيمة مختلفة أو فارغة
                if ($shipping->state_id !== $correctStateId) {
                    DB::table('shippings')
                        ->where('id', $shipping->id)
                        ->update(['state_id' => $correctStateId]);
                    $updatedCount++;
                }
            } else {
                // تسجيل الولايات التي لم يتم العثور على تطابق لها
                $notFound[] = $shipping->state_fr;
            }
        }

        $this->command->info("Update complete. {$updatedCount} records were updated.");
        if (!empty($notFound)) {
            $this->command->warn('The following states could not be found in the mapping array: ' . implode(', ', array_unique($notFound)));
        }
    }
}
