<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->integer('projet_id');
            $table->integer('employeur_id');
            $table->string('statut')->default('offre_service_signe')->nullable();

            $table->integer('nb_candidat')->default(1)->nullable();
            $table->text('type_emploi')->nullable();
            $table->text('territoires')->nullable();
            $table->string('procedure')->nullable();
            $table->date('date_debut_mandat')->nullable();

            $table->date('eimt_date_envoi')->nullable();
            $table->date('eimt_date_accuse_rec')->nullable();
            $table->date('eimt_date_reception')->nullable();
            $table->date('eimt_date_echeance')->nullable();
            $table->string('eimt_numero')->nullable();

            $table->date('dst_date_envoi')->nullable();
            $table->date('dst_date_accuse_rec')->nullable();
            $table->date('dst_date_reception')->nullable();
            $table->date('dst_date_echeance')->nullable();
            $table->string('dst_numero')->nullable();

            $table->string('contact_nom')->nullable();
            $table->string('contact_prenom')->nullable();
            $table->string('contact_titre')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->integer('contact_ext')->nullable();

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
        Schema::dropIfExists('demandes');
    }
}
