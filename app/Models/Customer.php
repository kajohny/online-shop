<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;    

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];
    
    public function orders() 
    {
        return $this->hasMany(Order::class);
    }
}
