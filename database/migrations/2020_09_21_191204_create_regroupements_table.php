<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegroupementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regroupements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });


        // Insert some stuff
        DB::table('regroupements')->insert([
            array('title' => 'CCAQ'),
            array('title' => 'TADA'),
            array('title' => 'ACVLQ'),
            array('title' => 'Olymel')]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regroupements');
    }
}
