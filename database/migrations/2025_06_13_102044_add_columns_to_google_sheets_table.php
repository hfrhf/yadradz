<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('google_sheets', function (Blueprint $table) {
            $table->longText('service_account_json')->nullable()->after('id');
            $table->string('spreadsheet_id')->nullable()->after('service_account_json');
            $table->string('sheet_name')->default('Orders')->after('spreadsheet_id');
            $table->boolean('is_active')->default(true)->after('sheet_name');
        });
    }

    public function down()
    {
        Schema::table('google_sheets', function (Blueprint $table) {
            $table->dropColumn([
                'service_account_json',
                'spreadsheet_id',
                'sheet_name',
                'is_active'
            ]);
        });
    }
};