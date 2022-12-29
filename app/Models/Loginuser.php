<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Loginuser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'loginusers';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'designation',
        'gender',
        'password',
        'confirmPassword',
        'status',
        'deleted_at',
    ];
    protected $primaryKey = 'id';
}
