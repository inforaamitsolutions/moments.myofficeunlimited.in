<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
   
    protected $table = 'employees';
    protected $fillable = [
       'name',
       'email',
       'phone',
       'photo',
       'designation',
       'gender',
       'address',
       'state',
       'country',
       'pincode',
       'password',
       'confirmPassword',
       'image',
       'status',
       'deleted_at',
    ];

    // protected $primaryKey = 'id';
    // protected $hidden = [ 'password', 'remember_token'];
}
