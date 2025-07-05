<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::createOrFirst(
            ['name' => 'اللون'], // ابحث عن خاصية بهذا الاسم
            [
                'name_fr' => 'Couleur', // الترجمة الفرنسية
                'is_locked' => true     // اجعلها محمية
            ]
        );
        Attribute::createOrFirst(
            ['name'=>'الحجم'],
            [
                'name_fr' => 'Taille', // الترجمة الفرنسية
                'is_locked' => true     // اجعلها محمية
            ]

        );
    }
}
