<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTodosAddColumnGroupId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function(Blueprint $table){
            $table->unsignedBigInteger('group_id')->index()->after('projet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todos', function(Blueprint $table){
            $table->dropColumn('group_id');
        });
    }
}
