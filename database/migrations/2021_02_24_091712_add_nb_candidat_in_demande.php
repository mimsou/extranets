<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNbCandidatInDemande extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->integer('nb_candidat_recrute')->after('nb_candidat')->nullable()->unsigned()->default(0);
        });

        $this->updateDemandes();
    }


    public function updateDemandes(){
        foreach(\App\Models\Demande::all() as $d){
            $d->nb_candidat_recrute = $d->candidats->count();
            $d->save();
        }
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
