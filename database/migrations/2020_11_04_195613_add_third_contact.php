<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThirdContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeurs', function (Blueprint $table) {
            $table->integer('contact_ext')->nullable()->after('contact_phone');
            $table->integer('secondary_contact_ext')->nullable()->after('secondary_contact_phone');
            $table->string('has_third_contact')->nullable()->after('secondary_contact_ext');
            $table->string('third_contact_nom')->nullable()->after('has_third_contact');
            $table->string('third_contact_prenom')->nullable()->after('third_contact_nom');
            $table->string('third_contact_titre')->nullable()->after('third_contact_prenom');
            $table->string('third_contact_email')->nullable()->after('third_contact_titre');
            $table->string('third_contact_phone')->nullable()->after('third_contact_email');
            $table->integer('third_contact_ext')->nullable()->after('third_contact_phone');
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
