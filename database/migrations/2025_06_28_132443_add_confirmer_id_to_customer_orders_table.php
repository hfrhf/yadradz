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
        Schema::table('customer_orders', function (Blueprint $table) {
            // FK لربط الطلب مع المستخدم الذي قام بتأكيده أو إلغائه
            $table->foreignId('confirmer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('confirmation_action_at')->nullable(); // لتخزين وقت اتخاذ الإجراء
        });
    }

    public function down()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropForeign(['confirmer_id']);
            $table->dropColumn(['confirmer_id', 'confirmation_action_at']);
        });
    }

};
