<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_name',
        'start_date',
        'state',
        'close_date',
        'closed_by_user',
    ];

    public function note_entries()
    {
        return $this->hasMany(Note_Entrie::class);
    }


    public function note_requests()
    {
        return $this->hasMany(NoteRequest::class);
    }
}
