<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note_Entrie extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $table = 'note_entries';

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'suppliers_id');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'entries_material', 'note_id', 'material_id')->withPivot('amount_entries', 'cost_unit', 'cost_total', 'name_material', 'request')->withTimestamps();
    }

    public static function getFirstNoteOfYear()
    {
        return self::whereYear('created_at', now()->year)
            ->orderBy('created_at', 'asc')
            ->first();
    }


    public static function formatDate($date)
    {
        return Carbon::parse($date)
            ->locale('es')
            ->translatedFormat('j \\d\\e F');
    }
}
