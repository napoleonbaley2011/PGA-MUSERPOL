<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolStore extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rol_stores';
    protected $guarded = [
        'name_rol'
    ];

    public function rolUsers() {
        return $this->belongsToMany(UserStore::class, 'user_rol_stores', 'user_id', 'rol_id');
    }
}
