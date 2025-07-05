<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipping;

class UpdateShippingFrenchNamesSeeder extends Seeder
{
    public function run(): void
    {
        $wilayas_fr = [
            "Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira",
            "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda",
            "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M'sila", "Mascara", "Ouargla",
            "Oran", "El Bayadh", "Illizi", "Bordj Bou Arréridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt", "El Oued", "Khenchela",
            "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane", "Timimoun", "Bordj Badji Mokhtar",
            "Ouled Djellal", "Béni Abbès", "In Salah", "In Guezzam", "Touggourt", "Djanet", "El M'ghair", "El Meniaa"
        ];

        foreach ($wilayas_fr as $index => $wilaya_fr) {
            $shipping = Shipping::find($index + 4); // لأن أول ولاية تبدأ من id = 4
            if ($shipping) {
                $shipping->update([
                    'state_fr' => $wilaya_fr
                ]);
            }
        }
    }
}
