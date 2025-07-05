
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminInfosTable extends Migration
{
    public function up()
    {
        Schema::create('admin_infos', function (Blueprint $table) {
            $table->id();
            $table->string('facebook')->nullable();
            $table->string('email')->nullable();
            $table->string('twitter')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable(); // إضافة حقل واتساب
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_infos');
    }
}
