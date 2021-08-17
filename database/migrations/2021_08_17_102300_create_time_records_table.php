<?php

use App\Models\Enum\TaskType;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projet_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('by_user_id')->index();
            $table->enum('task_type', TaskType::all());
            $table->text('description')->default('');
            $table->float('duration', 8,4);
            $table->date('date_from');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_records');
    }
}
