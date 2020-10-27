<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('statut')->default('actif')->nullable();
            $table->string('adresse')->nullable();
            $table->string('adresse_2')->nullable();
            $table->string('ville')->nullable();
            $table->string('province')->nullable();
            $table->string('pays')->nullable();
            $table->string('zip')->nullable();
            $table->string('contact_nom')->nullable();
            $table->string('contact_prenom')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
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
        Schema::dropIfExists('employeurs');
    }
}
