<?php

namespace App\Domain\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['username', 'email', 'password', 'api_token'];

    protected $hidden = [
        'password',
        'api_token',
    ];
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
