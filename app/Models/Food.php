<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'food'; // Tentukan nama tabel yang benar

    protected $fillable = [
        'name', 'calories', 'description', 'portion', 'meal_time', 'macro', 'gi', 'fiber', 'image_url', 'reference_url',
    ];

    protected $casts = [
        'meal_time' => 'array',
        'macro' => 'array',
    ];
}