<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFewThings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projet_candidat', function (Blueprint $table) {
            $table->renameColumn('projet_id', 'demande_id');
        });

        Schema::rename('projet_candidat', 'demande_candidat');

        Schema::table('candidats', function (Blueprint $table) {
            $table->dropColumn('eimt_date_reception');
            $table->dropColumn('eimt_date_accuse_rec');
            $table->dropColumn('eimt_date_envoi');
            $table->dropColumn('eimt_numero');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test', function (Blueprint $table) {
            //
        });
    }
}
