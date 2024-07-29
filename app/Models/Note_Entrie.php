<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note_Entrie extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $table = 'note_entries';

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'suppliers_id');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'entries_material', 'note_id', 'material_id')->withPivot('amount_entries', 'cost_unit', 'cost_total', 'name_material', 'request')->withTimestamps();
    }
}
