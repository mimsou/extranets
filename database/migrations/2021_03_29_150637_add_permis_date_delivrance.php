<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermisDateDelivrance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->date('permis_date_delivrance')->nullable()->after('permis_date_envoi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidats', function (Blueprint $table) {
            //
        });
    }
}
