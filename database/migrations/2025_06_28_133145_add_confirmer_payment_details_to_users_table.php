<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('confirmer_payment_type', ['per_order', 'monthly_salary'])->nullable();
            // العمولة التي يحصل عليها المؤكد عن كل طلب مؤكد
            $table->decimal('confirmer_payment_rate', 8, 2)->nullable()->comment('Commission for a confirmed order');
            // العمولة التي يحصل عليها المؤكد عن كل طلب حاول تأكيده ولكنه أُلغي (مكافأة على الجهد)
            $table->decimal('confirmer_cancellation_rate', 8, 2)->nullable()->comment('Commission for a canceled order (effort reward)');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
