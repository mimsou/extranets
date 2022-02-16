<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTodoGroupsAddColumnTemplateName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todo_groups', function(Blueprint $table){
            $table->string('todo_title')->nullable()->after('projet_id');
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
            $table->dropColumn('todo_title');
        });
    }
}
