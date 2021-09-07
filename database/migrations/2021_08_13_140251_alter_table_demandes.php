<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDemandes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function(Blueprint $table){
            $table->string('la_region',200)->nullable()->after('code_cnp');
            $table->string('nom_de_laccompagnateur',200)->nullable()->after('la_region');
            $table->string('type_de_demande',100)->nullable()->after('nom_de_laccompagnateur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demandes', function(Blueprint $table){
            $table->dropColumn('la_region');
            $table->dropColumn('nom_de_laccompagnateur');
            $table->dropColumn('type_de_demande');
        });
    }
}
