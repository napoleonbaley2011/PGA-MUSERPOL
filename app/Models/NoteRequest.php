<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoteRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'note_requests';

    protected $guarded = [];

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'request_material', 'note_id', 'material_id')->withPivot('amount_request', 'name_material', 'delivered_quantity', 'costDetails')->withTimestamps();
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_register');
    }
}
