<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'name_group',
        'state',
    ];


    public function Classifier(){
        return $this->belongsTo(Classifier::class);
    }
    public function materials(){
        return $this->hasMany(Material::class);
    }
}
