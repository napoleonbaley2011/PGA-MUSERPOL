<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code_material',
        'description',
        'unit_material',
        'state',
        'stock',
        'min',
        'barcode',
        'group_id'
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function entry(){
        return $this->belongsTo(Entry::class);
    }
    public function note_entries(){
        return $this->belongsToMany(Note_Entrie::class, 'entries_material', 'note_id', 'material_id')->withPivot('amount_entries', 'cost_unit', 'brand');
    }
}
