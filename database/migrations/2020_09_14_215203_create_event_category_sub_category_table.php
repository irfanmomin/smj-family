<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCategorySubCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smj_event_category', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Main Category ID');
            $table->string('category_name', 255)->comment('Main Category name: Relief, Ujani');
            $table->timestamp('created_at')->nullable()->comment('Created At');
        });

        Schema::create('smj_event_subcategory', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Member ID');
            $table->integer('category_id')->comment('Main Category ID: Relief, Ujani');
            $table->integer('event_group_id')->comment('Event Group ID: Dholka, All');
            $table->string('sub_category_name', 255)->comment('Relief-2020');
            $table->integer('created_by')->unsigned()->comment('Created By');
            $table->timestamp('created_at')->nullable()->comment('Created At');
            $table->integer('updated_by')->nullable()->unsigned()->comment('Updated By');
            $table->timestamp('updated_at')->nullable()->comment('Updated At');
            $table->timestamp('deleted_at')->nullable();

            $table->index('category_id');
            $table->index('event_group_id');
        });

        DB::connection('mysql')->statement("INSERT INTO `smj_event_category` (`id`, `category_name`, `created_at`) VALUES (NULL, 'Relief Committee', NULL);");
        DB::connection('mysql')->statement("INSERT INTO `smj_event_category` (`id`, `category_name`, `created_at`) VALUES (NULL, 'Lilajpur Fund', NULL);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smj_event_category');
        Schema::dropIfExists('smj_event_subcategory');
    }
}
