<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function calculations()
    {
        return $this->hasMany(Calculation::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}