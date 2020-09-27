<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smj_main_trans', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Main Transaction ID');
            $table->integer('category_id')->comment('Category ID');
            $table->integer('sub_category_id')->comment('Sub Category ID');
            $table->float('amount', 13, 2)->comment('Debit Amount for all respected members');
            $table->integer('created_by')->unsigned()->comment('Created By');
            $table->timestamp('created_at')->nullable()->comment('Created At');
            $table->integer('updated_by')->nullable()->unsigned()->comment('Updated By');
            $table->timestamp('updated_at')->nullable()->comment('Updated At');
            $table->timestamp('deleted_at')->nullable();

            $table->index('category_id');
            $table->index('sub_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smj_main_trans');
    }
}
