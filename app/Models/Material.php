<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code_material',
        'description',
        'unit_material',
        'state',
        'stock',
        'min',
        'barcode',
        'type',
        'group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function noteEntries()
    {
        return $this->belongsToMany(Note_Entrie::class, 'entries_material', 'material_id', 'note_id')->withPivot('amount_entries', 'cost_unit', 'cost_total', 'name_material', 'request')->withTimestamps();
    }

    public function noteRequests()
    {
        return $this->belongsToMany(NoteRequest::class, 'request_material', 'material_id', 'note_id')->withPivot('amount_request', 'name_material', 'delivered_quantity')->withTimestamps();
    }
}
