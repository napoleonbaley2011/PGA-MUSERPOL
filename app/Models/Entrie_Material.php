<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entrie_Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'entries_material';

    protected $fillable = [
        'note_id',
        'material_id',
        'amount_entries',
        'request',
        'cost_unit',
        'cost_total',
        'name_material',
        'delivery_date_entry'
    ];

    public function noteEntry()
    {
        return $this->belongsTo(Note_Entrie::class, 'note_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
