<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classifier extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code_class',
        'nombre',
        'description'
    ];

    public function groups(){
        return $this->hasMany(Group::class);
    }
}
