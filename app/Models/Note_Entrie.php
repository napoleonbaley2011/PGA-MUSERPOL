<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note_Entrie extends Model
{
    use HasFactory;
    protected $table = 'note_entries';
    protected $guarded = [
        'number_note',
        'invoice_number',
        'delivery_date',
        'state',
        'invoice_auth',
        'user_register',
        'observation',
        'amount_articles',
        'suppliers_id'
    ];

    public function Supplier(){
        return $this->belongsTo(Supplier::class, 'suppliers_id');
    }

    public function Materials(){
        return $this->belongsToMany(Material::class,'entries_material', 'note_id', 'material_id')->withPivot('amount_entries', 'cost_unit', 'brand');
    }
    
}
