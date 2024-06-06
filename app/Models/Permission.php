<?php

namespace App\Models;

use Laratrust\Models\Permission as LaratrustPermission;

class Permission extends LaratrustPermission
{
	public $timestamps = true;
	public $guarded = ['id'];
	protected $fillable = ['name', 'display_name', 'description'];
	protected $table = 'public.permissions';
}
