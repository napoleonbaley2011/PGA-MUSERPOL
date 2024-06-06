<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requestd extends Model
{
    use HasFactory;
    protected $fillable = [
        'state',
        'delivery_date',
        'validate',
        'message',
        'number_note',
        'amount',   
        'total',
        'employees_id',
    ];
    protected $casts = [
        'delivery_date' => 'datetime',
    ];


}
