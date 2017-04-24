<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReassignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reassignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_user_id')->unsigned();
            $table->integer('assigned_to_user_id')->unsigned();
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('owner_user_id')->references('id')->on('users');
            $table->foreign('assigned_to_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reassignments');
    }
}
