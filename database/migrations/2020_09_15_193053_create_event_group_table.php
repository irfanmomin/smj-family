<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smj_event_group', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Event Group ID');
            $table->string('event_group_name', 255)->comment('Event Group name');
        });

        DB::connection('mysql')->statement("INSERT INTO `smj_event_group` (`id`, `event_group_name`) VALUES (NULL, 'Family wise (Dholka)');");
        DB::connection('mysql')->statement("INSERT INTO `smj_event_group` (`id`, `event_group_name`) VALUES (NULL, 'Family wise (All City)');");
        DB::connection('mysql')->statement("INSERT INTO `smj_event_group` (`id`, `event_group_name`) VALUES (NULL, 'All Members (Dholka)');");
        DB::connection('mysql')->statement("INSERT INTO `smj_event_group` (`id`, `event_group_name`) VALUES (NULL, 'All Members (All City)');");
        DB::connection('mysql')->statement("INSERT INTO `smj_event_group` (`id`, `event_group_name`) VALUES (NULL, 'Adult (Dholka)');");
        DB::connection('mysql')->statement("INSERT INTO `smj_event_group` (`id`, `event_group_name`) VALUES (NULL, 'Adult (All)');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smj_event_group');
    }
}
