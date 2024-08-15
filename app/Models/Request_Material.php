<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request_Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'request_material';

    protected $fillable = [
        'note_id', 'material_id', 'amount_request', 'delivered_quantity', 'name_material', 'costDetails'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function noteRequest()
    {
        return $this->belongsTo(NoteRequest::class, 'note_id');
    }
}
