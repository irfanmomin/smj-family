<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersPendingAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smj_members_pending_amount', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Increment ID');
            $table->integer('member_id')->unique()->comment('Member ID');
            $table->float('pending_amount', 13, 2)->comment('Total Pending Amount');

            $table->index('member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smj_members_pending_amount');
    }
}
