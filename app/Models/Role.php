<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    protected $table = "public.roles";
    public $timestamps = true;
	public $guarded = ['id'];
	protected $fillable = ['name', 'display_name', 'description'];
}

