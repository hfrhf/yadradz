<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_image')->default('header_images/com.jpg')->nullable();
            $table->string('logo')->default('images/logo.png')->nullable();
            $table->string('site_name')->default('متجري')->nullable();
            $table->text('content')->default('تسوق معنا وتعال الى رحلة غامرة من المتعة و النظر وانت من بيتك فقط ماذا تنتظر')->nullable();
            $table->string('sidebar_color')->nullable();
            $table->string('background_opacity', 7)->default('#16117D');
            $table->decimal('opacity', 3, 2)->default(0.57);
            $table->timestamps();
        });

        // إضافة سجل افتراضي إذا لم يكن موجودًا
        \Illuminate\Support\Facades\DB::table('settings')->insertOrIgnore([
            'id' => 1,
            'header_image' => 'header_images/com.jpg',
            'logo' => 'images/logo.png',
            'site_name' => 'متجري',
            'content' => 'تسوق معنا وتعال الى رحلة غامرة من المتعة و النظر وانت من بيتك فقط ماذا تنتظر',
            'sidebar_color' => null,
            'background_opacity' => '#16117D',
            'opacity' => 0.57,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
