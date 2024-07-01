<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classifier extends Model
{
    use HasFactory;
    use SoftDeletes; 
    
    protected $fillable = [
        'code_class',
        'nombre',
        'description'
    ];

    public function groups(){
        return $this->hasMany(Group::class);
    }
}
