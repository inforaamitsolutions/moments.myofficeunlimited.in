<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('photo')->nullable();
            $table->text('gender')->nullable();
            $table->text('designation')->nullable();
            $table->text('address')->nullable();
            $table->text('state')->nullable();
            $table->text('country')->nullable();
            $table->text('pincode')->nullable();
            $table->text('password')->nullable();
            $table->text('confirmPassword')->nullable();
            $table->text('image')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
