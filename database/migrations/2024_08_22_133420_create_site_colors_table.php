<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteColorsTable extends Migration
{
    public function up()
    {
        Schema::create('site_colors', function (Blueprint $table) {
            $table->id();
            $table->string('primary_color')->default('#054A91');
            $table->string('title_color')->default('#303036');
            $table->string('text_color')->default('#FAFAFA');
            $table->string('button_color')->default('#D90368');
            $table->string('price_color')->default('#27AE60');
            $table->string('footer_color')->default('#012851');
            $table->string('navbar_color')->default('#ffffff');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_colors');
    }
}
