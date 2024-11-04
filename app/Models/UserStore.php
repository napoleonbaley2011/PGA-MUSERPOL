<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStore extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_stores';

    protected $guarded = [
        'name_user',
        'rol',
        'active',
    ];

    public function rolUsers()
    {
        return $this->belongsToMany(RolStore::class, 'user_rol_stores', 'user_id', 'rol_id');
    }
}
