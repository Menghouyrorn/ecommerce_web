<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleModel extends Model
{
    protected $table = 'role';

    protected $fillable = [
        'name'
    ];

    public function permission(): BelongsToMany
    {
        return $this->BelongsToMany(PermissionModel::class, 'role_permission', 'role_id', 'permission_id');
    }

    public function user(): HasMany
    {
        return $this->HasMany(UserModel::class, 'role_id', 'id');
    }
}
