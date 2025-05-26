<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities'; // Tentukan nama tabel yang benar

    protected $fillable = [
        'name', 'calories_burned', 'intensity', 'description', 'duration', 'equipment', 'muscle_groups', 'category', 'reference_url',
    ];

    protected $casts = [
        'equipment' => 'array',
        'muscle_groups' => 'array',
    ];
}