<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImmigrationFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->date('eimt_date_envoi')->nullable()->after('com_immigration');
            $table->date('eimt_date_accuse_rec')->nullable()->after('com_immigration');
            $table->date('eimt_date_reception')->nullable()->after('com_immigration');
            $table->string('eimt_numero')->nullable()->after('com_immigration');

            $table->date('dst_date_envoi')->nullable()->after('com_immigration');
            $table->date('dst_date_accuse_rec')->nullable()->after('com_immigration');
            $table->date('dst_date_reception')->nullable()->after('com_immigration');
            $table->string('dst_numero')->nullable()->after('com_immigration');


            $table->date('permis_date_envoi')->nullable()->after('com_immigration');
            $table->date('permis_date_reception')->nullable()->after('com_immigration');
            $table->date('permis_date_echeance')->nullable()->after('com_immigration');
            $table->date('permis_date_renouvellement')->nullable()->after('com_immigration');

            $table->date('date_mandat_immigration')->nullable()->after('com_immigration');
            $table->integer('immigration_user_id')->nullabe()->unsigned()->after('com_immigration');
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
