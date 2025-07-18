<?php

namespace Database\Seeders;

use App\Models\Shipping;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        
        $wilayas = [
            "أدرار", "الشلف", "الأغواط", "أم البواقي", "باتنة", "بجاية", "بسكرة", "بشار", "البليدة", "البويرة",
            "تمنراست", "تبسة", "تلمسان", "تيارت", "تيزي وزو", "الجزائر", "الجلفة", "جيجل", "سطيف", "سعيدة",
            "سكيكدة", "سيدي بلعباس", "عنابة", "قالمة", "قسنطينة", "المدية", "مستغانم", "المسيلة", "معسكر", "ورقلة",
            "وهران", "البيض", "إليزي", "برج بوعريريج", "بومرداس", "الطارف", "تندوف", "تيسمسيلت", "الوادي", "خنشلة",
            "سوق أهراس", "تيبازة", "ميلة", "عين الدفلى", "النعامة", "عين تموشنت", "غرداية", "غليزان", "تميمون", "برج باجي مختار",
            "أولاد جلال", "بني عباس", "عين صالح", "عين قزام", "تقرت", "جانت", "المغير", "المنيعة"
        ];

        foreach ($wilayas as $wilaya) {
            Shipping::create([
                'state'=>$wilaya,
                'to_office_price'=>rand(200,600),
                'to_home_price'=>rand(400,900),
            ]);
        }
    }
}
