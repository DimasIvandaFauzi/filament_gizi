<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('calories_burned');
            $table->integer('intensity');
            $table->text('description');
            $table->string('duration');
            $table->json('equipment');
            $table->json('muscle_groups');
            $table->string('category');
            $table->string('reference_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
}