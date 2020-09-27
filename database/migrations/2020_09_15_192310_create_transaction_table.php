<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smj_transactions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Transaction ID');
            $table->integer('main_trans_id')->nullable()->comment('Main Transaction ID');
            $table->integer('member_id')->comment('Member ID for whom transaction is made');
            $table->tinyInteger('trans_type')->comment('1: credit | 2: debit ');
            $table->float('amount', 13, 2)->comment('Credited/Debited Amount');
            $table->string('receipt_no', 255)->nullable()->comment('Receipt Number if any');
            $table->text('note', 455)->nullable()->comment('Notes if any');
            $table->date('transaction_date')->nullable()->comment('Transaction Date');
            $table->integer('created_by')->unsigned()->comment('Created By');
            $table->timestamp('created_at')->comment('Created At');

            $table->index('main_trans_id');
            $table->index('member_id');
            $table->index('trans_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smj_transactions');
    }
}
