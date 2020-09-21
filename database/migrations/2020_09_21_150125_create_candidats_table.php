<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('numero')->nullable();
            $table->enum('statut', ['disponible', 'en_traitement', 'en_emploi', 'termine', 'retire', 'non_recrute'])->defautl('disponible');
            $table->integer('recruteur_id')->nullable();
            $table->integer('emploi_id')->nullable();
            $table->date('date_debut_recrutement')->nullable();
            $table->date('date_selection')->nullable();
            $table->string('pays_recrutement')->nullable();
            $table->integer('mission_id')->nullable();
            $table->date('date_arrive')->nullable();
            $table->date('date_debut_emploi')->nullable();
            $table->date('date_fin_emploi')->nullable();
            $table->integer('regroupement_id')->nullable();
            $table->string('nom_employeur')->nullable();
            $table->string('no_projet_initial')->nullable();
            $table->string('no_projet_renouvellement')->nullable();
            $table->string('no_projet_autre')->nullable();
            $table->longText('com_candidat')->nullable();
            $table->longText('com_recrutement')->nullable();
            $table->longText('com_bureau_etranger')->nullable();
            $table->longText('com_immigration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidats');
    }
}
