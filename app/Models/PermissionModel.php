<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PermissionModel extends Model
{
    protected $table = 'permission';

    protected $fillable = [
        'permission'
    ];

    public function role():BelongsToMany
    {
        return $this->belongsToMany(RoleModel::class, 'role_permission', 'permission_id', 'role_id');
    }
}
