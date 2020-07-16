<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAreaCityRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'KAJITEKRA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'BHIKANSHAHID DARGAH');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'ZABUK MOHALLA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'BARCHORA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'SURTI MOHALLA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'RENWADA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'BAWA NA GHAR PASE');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'BURAJ ROAD');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'JAMATKHANA PASE');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'GAJIYA NI KHADKI');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'DARGAH PASE');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'BADI-BU POLICE LINE');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'DAWAKHANA PASE');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'DUNGRI NO DELO');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'ABDAL FALIYA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'KHADIYA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'MOCHIWAD');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'DADUFALIYA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'TANKAFALIYA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'BADAMSHAHID DARGAH');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'JIGAR SIJING');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'GANIPUR');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'MIRKUVA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'LILAJPUR');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'DHOLKA', 'MAFATIYAPURA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'AHMEDABAD', 'SARKHEJ');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'AHMEDABAD', 'JUHAPURA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'AHMEDABAD', 'KALUPUR');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'AHMEDABAD', 'JAMALPUR');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'KHEDA', 'KHEDA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'NADIAD', 'NADIAD');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'VASO', 'VASO');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'BARODA', 'BARODA');");
        DB::connection('mysql')->statement("INSERT INTO `area_city` (`id`, `city`, `area`) VALUES (NULL, 'WANKANER', 'WANKANER');");
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
