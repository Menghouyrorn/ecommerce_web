<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreModel extends Model
{
    protected $table = 'store';

    protected $fillable = [
        'store_no',
        'store_name',
        'store_address',
        'store_phone',
        'store_email',
        'store_telegram',
        'manager_id'
    ];

    public function Manager(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'manager_id', 'id');
    }

    public function Employee(): BelongsToMany
    {
        return $this->belongsToMany(UserModel::class, 'user_has_store', 'user_id','store_id');
    }
}
