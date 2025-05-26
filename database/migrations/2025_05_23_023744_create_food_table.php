<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('calories');
            $table->text('description');
            $table->string('portion');
            $table->json('meal_time');
            $table->json('macro');
            $table->integer('gi');
            $table->integer('fiber');
            $table->string('image_url')->nullable();
            $table->string('reference_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food');
    }
}