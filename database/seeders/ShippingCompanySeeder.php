<?php
namespace Database\Seeders;

use App\Models\ShippingCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['name' => 'Yalidine', 'slug' => 'yalidine'],
            ['name' => 'ZR Express', 'slug' => 'zr-express'],
            ['name' => 'Ecotrack', 'slug' => 'ecotrack'],
            ['name' => 'NOEST Express', 'slug' => 'noest'],
            ['name' => 'Maystro Delivery', 'slug' => 'maystro'],
            ['name' => 'Guepex', 'slug' => 'guepex'],
            ['name' => 'E-com Delivery', 'slug' => 'ecom-delivery'],
            ['name' => 'Zimou Express', 'slug' => 'zimou'],
        ];

        foreach ($companies as $company) {
            ShippingCompany::firstOrCreate(
                ['slug' => $company['slug']], // ابحث بهذا الحقل
                ['name' => $company['name']]  // إذا لم تجده، أنشئه بهذه البيانات
            );
        }
    }
}