<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('google_sheets_settings');
    }

    public function down(): void
    {
        Schema::create('google_sheets_settings', function (Blueprint $table) {
            $table->id();
            $table->text('client_id')->nullable();
            $table->text('client_secret')->nullable();
            $table->string('sheet_id')->nullable();
            $table->timestamps();
        });
    }
};