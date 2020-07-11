<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Member ID');
            $table->integer('family_id')->nullable()->comment('Family ID / Parent ID');
            $table->string('firstname', 255)->comment('First Name');
            $table->string('lastname', 255)->comment('Last Name');
            $table->string('surname', 255)->nullable()->comment('Surname eg. Ghodawala, Shethwala');
            $table->string('mobile', 11)->comment('Member Mobile Number');
            $table->date('dob')->comment('Member DOB');
            $table->string('gender', 2)->comment('M: Male | F: Female');
            $table->string('relation', 65)->default('Self')->comment(' Self | Father | Mother | Wife | Brother | Sister | Son | Daughter | Uncle | Aunty | Daughter in law | Sister in law | Cousin | Husband');
            $table->string('area', 95)->nullable()->comment('Area');
            $table->string('city', 65)->nullable()->comment('City');
            $table->tinyInteger('is_main')->default(0)->comment('Is this main member of family?');
            $table->date('expired_date')->nullable()->comment('In case member is expired');
            $table->integer('created_by')->unsigned()->comment('Created By');
            $table->timestamp('created_at')->nullable()->comment('Created At');
            $table->integer('updated_by')->nullable()->unsigned()->comment('Updated By');
            $table->timestamp('updated_at')->nullable()->comment('Updated At');
            $table->timestamp('deleted_at')->nullable();

            $table->index('family_id');
            $table->index('is_main');
            $table->index('area');
            $table->index('city');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
