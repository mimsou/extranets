<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emplois', function (Blueprint $table) {
            $table->id();
            $table->string('abrev',3);
            $table->string('title');
            $table->timestamps();
        });


        // Insert some stuff
        DB::table('emplois')->insert([['abrev' => 'AS', 'title' => 'Assembleur'],
               ['abrev' => 'CL', 'title' => 'Opérateur coupe laser'],
               ['abrev' => 'CM', 'title' => 'Concepteur mécanique'],
               ['abrev' => 'CO', 'title' => 'Conducteur - chauffeur véhicules lourds'],
               ['abrev' => 'CP', 'title' => 'Commis aux pièces'],
               ['abrev' => 'CT', 'title' => 'Conseiller technique automobile'],
               ['abrev' => 'CU', 'title' => 'Cuisinier'],
               ['abrev' => 'DB', 'title' => 'Débosseleur'],
               ['abrev' => 'EB', 'title' => 'Ebéniste'],
               ['abrev' => 'GL', 'title' => 'Galvaniseur'],
               ['abrev' => 'GR', 'title' => 'Graphiste'],
               ['abrev' => 'IC', 'title' => 'Ingénieur mécanique'],
               ['abrev' => 'IM', 'title' => 'Ingénieur maintenance'],
               ['abrev' => 'IQ', 'title' => 'Ingénieur qualité'],
               ['abrev' => 'LA', 'title' => "Laveur (Préposé à l'esthétique)"],
               ['abrev' => 'MA', 'title' => 'Mécanicien automobile'],
               ['abrev' => 'MC', 'title' => 'Machiniste'],
               ['abrev' => 'MD', 'title' => 'Modeleur'],
               ['abrev' => 'ME', 'title' => 'Meuleur'],
               ['abrev' => 'MI', 'title' => 'Mécanicien industriel'],
               ['abrev' => 'MN', 'title' => 'Maçon'],
               ['abrev' => 'MO', 'title' => 'Manoeuvre (ouvrier)'],
               ['abrev' => 'OF', 'title' => 'Ouvrier de fonderie (mouleur)'],
               ['abrev' => 'OS', 'title' => 'Opérateur de presse plieuse'],
               ['abrev' => 'PT', 'title' => 'Programmeur TI'],
               ['abrev' => 'RM', 'title' => 'Rembourreur de meubles'],
               ['abrev' => 'SA', 'title' => 'Soudeur-Assembleur'],
               ['abrev' => 'SO', 'title' => 'Soudeur'],
               ['abrev' => 'TC', 'title' => 'Technicien en comptabilité'],
               ['abrev' => 'TM', 'title' => 'Technicien en métalurgie'],
               ['abrev' => 'VB', 'title' => 'Mécanicien bus'],
               ['abrev' => 'VL', 'title' => 'Mécanicien véhicules lourds et engins'] ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emplois');
    }
}
