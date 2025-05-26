<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'age',
        'weight',
        'height',
        'activity',
        'goal',
        'bmi',
        'status_bmi',
        'macronutrient_needs', // Tambahkan kolom ini
    ];

    protected $casts = [
        'macronutrient_needs' => 'array', // Konversi JSON ke array saat diambil
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}