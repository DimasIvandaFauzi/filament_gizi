<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('gender');
            $table->integer('age');
            $table->float('weight');
            $table->float('height');
            $table->string('activity');
            $table->string('goal');
            $table->float('bmi');
            $table->string('status_bmi');
            $table->json('macronutrient_needs')->nullable(); // Tambahkan kolom untuk kebutuhan makronutrien
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};