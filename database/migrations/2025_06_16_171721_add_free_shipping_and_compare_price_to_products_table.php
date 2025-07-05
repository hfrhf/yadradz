<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreeShippingAndComparePriceToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('compare_price', 10, 2)->nullable()->after('price'); // سعر المقارنة
            $table->boolean('free_shipping_office')->default(false)->after('compare_price');
            $table->boolean('free_shipping_home')->default(false)->after('free_shipping_office');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'free_shipping_office',
                'free_shipping_home',
                'compare_price',
            ]);
        });
    }
}
