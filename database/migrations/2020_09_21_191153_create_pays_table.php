<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string('abrev',3);
            $table->string('title');
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('pays')->insert([
            array('abrev' => 'BRE', 'title' => 'Brésil'),
            array('abrev' => 'BFA', 'title' => 'Burkina Faso'),
            array('abrev' => 'KHM', 'title' => 'Cambodge'),
            array('abrev' => 'CMR', 'title' => 'Cameroun'),
            array('abrev' => 'COL', 'title' => 'Colombie'),
            array('abrev' => 'KOR', 'title' => 'Corée du Sud (South Korea)'),
            array('abrev' => 'USA', 'title' => 'Éats-Unis'),
            array('abrev' => 'FRA', 'title' => 'France'),
            array('abrev' => 'GEN', 'title' => 'Générique'),
            array('abrev' => 'GRB', 'title' => 'Grande-Bretagne'),
            array('abrev' => 'MAR', 'title' => 'Maroc'),
            array('abrev' => 'MEX', 'title' => 'Mexique'),
            array('abrev' => 'POL', 'title' => 'Pologne'),
            array('abrev' => 'SEN', 'title' => 'Sénégal'),
            array('abrev' => 'TUN', 'title' => "Tunisie")]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pays');
    }
}
