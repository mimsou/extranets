<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCandidatsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidats', function(Blueprint $table){
            $table->string('etat_civil')->nullable()->after('dst_date_envoi');
            $table->integer('nombre_d_enfants')->nullable()->after('etat_civil');
            $table->integer('age_d_enfants')->nullable()->after('nombre_d_enfants');
            $table->text('address_1')->nullable()->after('age_d_enfants');
            $table->text('address_2')->nullable()->after('address_1');
            $table->string('city')->nullable()->after('address_2');
            $table->string('province')->nullable()->after('city');
            $table->string('country')->nullable()->after('province');
            $table->string('postal_code')->nullable()->after('country');
            $table->date('date_d_arrivee')->nullable()->after('postal_code');
            $table->string('nom_de_l_accompagnateur')->nullable()->after('date_d_arrivee');
            $table->string('la_region_de_lemploi')->nullable()->after('nom_de_l_accompagnateur');
            $table->string('contact_telephonique')->nullable()->after('la_region_de_lemploi');
            $table->string('lien_facebook')->nullable()->after('contact_telephonique');
            $table->string('whatsapp')->nullable()->after('lien_facebook');
            $table->text('commentaires_generaux')->nullable()->after('whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidats', function(Blueprint $table){
            $table->dropColumn('etat_civil');
            $table->dropColumn('nombre_d_enfants');
            $table->dropColumn('age_d_enfants');
            $table->dropColumn('address_1');
            $table->dropColumn('address_2');
            $table->dropColumn('city');
            $table->dropColumn('province');
            $table->dropColumn('country');
            $table->dropColumn('postal_code');
            $table->dropColumn('date_d_arrivee');
            $table->dropColumn('nom_de_l_accompagnateur');
            $table->dropColumn('la_region_de_lemploi');
            $table->dropColumn('contact_telephonique');
            $table->dropColumn('lien_facebook');
            $table->dropColumn('whatsapp');
            $table->dropColumn('commentaires_generaux');
        });
    }
}
