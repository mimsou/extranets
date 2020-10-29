<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeurs', function (Blueprint $table) {
            $table->string('contact_titre')->nullable()->after('contact_prenom');
            $table->string('has_secondary_contact')->nullable()->after('contact_phone');
            $table->string('secondary_contact_nom')->nullable()->after('has_secondary_contact');
            $table->string('secondary_contact_prenom')->nullable()->after('secondary_contact_nom');
            $table->string('secondary_contact_titre')->nullable()->after('secondary_contact_prenom');
            $table->string('secondary_contact_email')->nullable()->after('secondary_contact_titre');
            $table->string('secondary_contact_phone')->nullable()->after('secondary_contact_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employeurs', function (Blueprint $table) {
            //
        });
    }
}
