<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->date('date_projet_initial')->nullable()->after('no_projet_initial');
            $table->date('date_projet_renouvellement')->nullable()->after('no_projet_renouvellement');
            $table->date('date_projet_autre')->nullable()->after('no_projet_autre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidats', function (Blueprint $table) {
            //
        });
    }
}
