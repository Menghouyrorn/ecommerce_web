<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $fillable = ['id', 'f_name', 'l_name', 'password', 'email', 'phone', 'role_id', 'store_id', 'remember_token'];

    protected $hidden = ['password'];


    public function role(): BelongsTo
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }

    public function store(): HasMany
    {
        return $this->hasMany(StoreModel::class, 'manager_id', 'id');
    }

}
