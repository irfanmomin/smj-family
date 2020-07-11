<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_city', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Member ID');
            $table->string('city', 65)->nullable()->comment('City Name');
            $table->string('area', 95)->nullable()->comment('Area Name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_city');
    }
}
