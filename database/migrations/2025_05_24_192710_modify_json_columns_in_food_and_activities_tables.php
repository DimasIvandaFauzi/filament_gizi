<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Food;
use App\Models\Activity;

class ModifyJsonColumnsInFoodAndActivitiesTables extends Migration
{
    public function up()
    {
        // Tambahkan kolom sementara bertipe json
        Schema::table('food', function (Blueprint $table) {
            $table->json('meal_time_new')->nullable();
            $table->json('macro_new')->nullable();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->json('equipment_new')->nullable();
            $table->json('muscle_groups_new')->nullable();
        });

        // Pindahkan data dari kolom lama ke kolom baru
        $foods = Food::all();
        foreach ($foods as $food) {
            $food->meal_time_new = json_decode($food->meal_time, true);
            $food->macro_new = json_decode($food->macro, true);
            $food->save();
        }

        $activities = Activity::all();
        foreach ($activities as $activity) {
            $activity->equipment_new = json_decode($activity->equipment, true);
            $activity->muscle_groups_new = json_decode($activity->muscle_groups, true);
            $activity->save();
        }

        // Hapus kolom lama dan ubah nama kolom baru
        Schema::table('food', function (Blueprint $table) {
            $table->dropColumn('meal_time');
            $table->dropColumn('macro');
            $table->renameColumn('meal_time_new', 'meal_time');
            $table->renameColumn('macro_new', 'macro');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('equipment');
            $table->dropColumn('muscle_groups');
            $table->renameColumn('equipment_new', 'equipment');
            $table->renameColumn('muscle_groups_new', 'muscle_groups');
        });
    }

    public function down()
    {
        Schema::table('food', function (Blueprint $table) {
            $table->longText('meal_time')->nullable();
            $table->longText('macro')->nullable();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->longText('equipment')->nullable();
            $table->longText('muscle_groups')->nullable();
        });

        // Pindahkan data kembali jika diperlukan (opsional)
        $foods = Food::all();
        foreach ($foods as $food) {
            $food->meal_time = json_encode($food->meal_time);
            $food->macro = json_encode($food->macro);
            $food->save();
        }

        $activities = Activity::all();
        foreach ($activities as $activity) {
            $activity->equipment = json_encode($activity->equipment);
            $activity->muscle_groups = json_encode($activity->muscle_groups);
            $activity->save();
        }

        Schema::table('food', function (Blueprint $table) {
            $table->dropColumn('meal_time_new');
            $table->dropColumn('macro_new');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('equipment_new');
            $table->dropColumn('muscle_groups_new');
        });
    }
}