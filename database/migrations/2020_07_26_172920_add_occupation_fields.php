<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOccupationFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('education', 55)->after('is_verified')->nullable()->comment('Education');
            $table->string('occupation', 55)->after('education')->nullable()->comment('Occupation');
            $table->integer('verified_by')->nullable()->after('is_verified')->unsigned()->comment('Verified By');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
