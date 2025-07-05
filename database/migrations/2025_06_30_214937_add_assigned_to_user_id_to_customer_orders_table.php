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
        Schema::table('customer_orders', function (Blueprint $table) {
            // هذا الحقل يحدد من هو المسؤول عن الطلب
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            // أولاً نحذف الـ foreign key
            $table->dropForeign(['assigned_to_user_id']);
            // ثم نحذف العمود نفسه
            $table->dropColumn('assigned_to_user_id');
        });
    }
};
