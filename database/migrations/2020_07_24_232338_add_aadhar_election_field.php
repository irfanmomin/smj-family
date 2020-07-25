<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAadharElectionField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('aadhar_id', 20)->after('surname')->nullable()->comment('Aadhar ID');
            $table->string('election_id', 25)->after('aadhar_id')->nullable()->comment('Election ID');
            $table->tinyInteger('is_verified')->after('expired_date')->default(0)->comment('Member Verified: 1 | Not Verified: 0');

            $table->index('aadhar_id');
            $table->index('is_verified');
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
