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
    Schema::table('shippings', function (Blueprint $table) {
        $table->string('state_fr')->nullable()->after('state'); // أو ضع after حسب العمود المناسب
    });
}

public function down()
{
    Schema::table('shippings', function (Blueprint $table) {
        $table->dropColumn('state_fr');
    });
}

};
