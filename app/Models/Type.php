<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_type',
        'balance'
    ];

    public function note_entries()
    {
        return $this->hasMany(Note_Entrie::class);
    }

    public function note_request()
    {
        return $this->hasMany(NoteRequest::class);
    }
}
