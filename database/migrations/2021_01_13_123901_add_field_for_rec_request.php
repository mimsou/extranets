<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldForRecRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            // $table->string('type')->default('immigration')->after('employeur_id')->nullable();
            // $table->string('conv_collective',3)->nullable()->after('contact_ext');
            // $table->string('rec_categorie',3)->nullable()->after('conv_collective');
            // $table->string('test_pratique',15)->nullable()->after('rec_categorie');
            // $table->string('bas_salaire',3)->nullable()->after('test_pratique');
            // $table->text('description_poste')->nullable()->after('bas_salaire');
            // $table->text('poste_fonctions')->nullable()->after('description_poste');
            // $table->text('poste_competences')->nullable()->after('poste_fonctions');
            // $table->text('autre_information')->nullable()->after('poste_competences');
            // $table->integer('annee_exp')->nullable()->after('autre_information');
            // $table->string('diplome')->nullable()->after('annee_exp');
            // $table->string('langue',2)->nullable()->after('diplome');
            // $table->string('salaire')->nullable()->after('langue');
            // $table->string('lieu_travail')->nullable()->after('salaire');
            // $table->string('code_cnp')->nullable()->after('lieu_travail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            //
        });
    }
}
