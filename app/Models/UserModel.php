<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Model
{
    use HasFactory, HasApiTokens,Notifiable;

    protected $table = 'users';
    protected $fillable = ['id', 'f_name', 'l_name', 'password', 'email', 'phone'];

    protected $hidden = ['password'];
}
