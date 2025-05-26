<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\CalculationController;
use App\Http\Controllers\API\CalculationHistoryController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\ProfileController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/me', [ProfileController::class, 'me'])->name('profile.me');
    Route::post('/calculate', [CalculationController::class, 'calculate'])->name('calculate');
    Route::get('/history', [CalculationController::class, 'history'])->name('history');

    Route::apiResource('foods', FoodController::class)->only(['index']);
    Route::apiResource('activities', ActivityController::class)->only(['index']);
    
    Route::apiResource('users', UserController::class)->middleware('admin');
    Route::apiResource('calculations', CalculationController::class);
    Route::apiResource('calculation-histories', CalculationHistoryController::class);
    Route::apiResource('schedules', ScheduleController::class);

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // User management
        Route::apiResource('users', UserController::class);

        // Full CRUD for foods and activities
        Route::prefix('admin')->group(function () {
            Route::apiResource('foods', FoodController::class)->names('admin.foods');
            Route::apiResource('activities', ActivityController::class)->names('admin.activities');
        });
    });
});

// Route untuk menangani gambar di /storage/
Route::get('/storage/{path}', function ($path) {
    $file = Storage::disk('public')->get($path);
    if (!$file) {
        abort(404);
    }
    $mimeType = Storage::disk('public')->mimeType($path);
    return response($file, 200)->header('Content-Type', $mimeType);
})->middleware('cors')->where('path', '.*');

Route::get('/ping', function () {
    return response()->json(['message' => 'Server is running', 'status' => 'ok']);
})->name('ping');