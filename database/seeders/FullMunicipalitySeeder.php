<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipality;
use App\Models\Shipping; // أو State إذا كنت تستخدم نموذجًا منفصلًا للولايات

class FullMunicipalitySeeder extends Seeder
{
    public function run(): void
    {
        $json = json_decode(file_get_contents(storage_path('app/algeria_cities_fr.json')), true);

        $inserted = 0;

        foreach ($json as $item) {
            $wilaya_ar = trim($item['wilaya_name']);
            $wilaya_fr = trim($item['wilaya_name_ascii']);
            $commune_ar = trim($item['commune_name']);
            $commune_fr = trim($item['commune_name_ascii']);

            // إيجاد الولاية حسب الاسم العربي
            $state = \App\Models\Shipping::where('state', $wilaya_ar)->first();

            if (!$state) {
                echo "⚠️ ولاية غير موجودة: $wilaya_ar - البلدية: $commune_ar\n";
                continue;
            }

            Municipality::create([
                'name' => $commune_ar,
                'name_fr' => $commune_fr,
                'state_id' => $state->id,
            ]);

            $inserted++;
        }

        echo "✅ تم إدخال $inserted بلدية بنجاح.\n";
    }
}
