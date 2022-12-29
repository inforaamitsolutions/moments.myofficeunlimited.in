<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('tasklist')->nullable();
            $table->text('desc')->nullable();
            $table->text('startDate')->nullable();
            $table->text('dueDate')->nullable();
            $table->text('priority')->nullable();
            $table->text('client')->nullable();
            $table->text('vendor')->nullable();
            $table->text('assignTo')->nullable();
            $table->text('forwardedTo')->nullable();
            $table->text('addedBy')->nullable();
            $table->text('project')->nullable();
            $table->text('status')->nullable();
            $table->text('images')->nullable();
            $table->text('deleted_at')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
