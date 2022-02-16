<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewProjectFields1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->integer('employeur_id')->unsigned()->index()->after('id');
            $table->datetime('date_creation')->nullable()->after('numero');
            $table->text('type_emploi')->nullable()->after('date_creation');
            $table->integer('nb_candidats')->default(1)->nullable()->after('date_creation');
        });

        Schema::create('projet_candidat', function (Blueprint $table) {
            $table->integer('projet_id')->unsigned()->index();
            $table->integer('candidat_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            //
        });
    }
}
