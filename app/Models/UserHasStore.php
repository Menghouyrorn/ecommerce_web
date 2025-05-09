<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasStore extends Model
{
    protected $table = 'user_has_store';

    protected $fillable = [
        'store_id',
        'user_id'
    ];
}
