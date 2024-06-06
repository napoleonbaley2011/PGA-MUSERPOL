<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAction extends Model
{
    use SoftDeletes;
	protected $table = 'public.user_actions';
	public $timestamps = true;
	public $guarded = ['id'];
	protected $dates = ['deleted_at'];
	protected $fillable = ['user_id', 'action'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
