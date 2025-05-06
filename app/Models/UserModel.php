<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Model
{
    use HasFactory,HasApiTokens;
    protected $table = 'users';
    protected $fillable = ['id', 'f_name', 'l_name','password', 'email', 'phone'];
}
