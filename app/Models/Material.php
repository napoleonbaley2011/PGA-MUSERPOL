<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'cost',
        'subtotal',
        'entrydate',
        'material_id',
        'entries_id',
        'invalidate',
        'state',
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function entry(){
        return $this->belongsTo(Entry::class);
    }
}
