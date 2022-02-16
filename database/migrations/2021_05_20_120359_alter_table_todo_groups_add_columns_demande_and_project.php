<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTodoGroupsAddColumnsDemandeAndProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todo_groups', function(Blueprint $table){
            $table->unsignedBigInteger('demande_id')->index()->after('status');
            $table->unsignedBigInteger('projet_id')->index()->after('demande_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todo_groups', function(Blueprint $table){
            $table->dropColumn('demande_id');
            $table->dropColumn('projet_id');
        });
    }
}
