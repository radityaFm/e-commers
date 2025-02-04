<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Order; // Jangan lupa import model Order jika kamu ingin membuat relasi

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function orders()
{
    return $this->hasMany(Order::class);
}

}
