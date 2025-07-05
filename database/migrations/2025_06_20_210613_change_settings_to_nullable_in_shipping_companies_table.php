<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            // تعديل العمود ليقبل قيمة NULL
            $table->json('settings')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            // الكود العكسي إذا أردت التراجع
            $table->json('settings')->nullable(false)->change();
        });
    }
};