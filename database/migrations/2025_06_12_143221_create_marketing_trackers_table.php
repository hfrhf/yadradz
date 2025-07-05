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
        Schema::create('marketing_trackers', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // facebook - tiktok - google-analytics - google-tag-manager
            $table->string('name')->nullable(); // اسم البيكسل (فقط للفيسبوك/تيكتوك)
            $table->string('identifier'); // pixel id أو GA ID
            $table->string('token')->nullable(); // access token (اختياري للفيسبوك مثلاً)
            $table->boolean('is_active')->default(true); // هل مفعل أم لا
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_trackers');
    }
};
