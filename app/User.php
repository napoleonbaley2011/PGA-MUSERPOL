<?php

namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Employee;
use App\Models\NoteRequest;
use App\Models\Permission;
use App\Models\UserAction;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;


class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasRolesAndPermissions, HasApiTokens;

    public $timetamps = true;
    public $guarded = ['id'];
    protected $dates = ['deleted_at'];


    protected $table = "public.users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'password',
        'username',
        'position',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'public.permission_user');
    }

    public function actions()
    {
        return $this->hasMany(UserAction::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function note_requests()
    {
        return $this->hasMany(NoteRequest::class);
    }

    /**
     * Accesor para obtener todos los permisos del usuario, incluidos los de roles
     *
     * @return array
     */
    public function getAllPermissionsAttribute()
    {
        $rolePermissions = $this->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        });

        $userPermissions = $this->permissions->pluck('name');

        return array_unique($rolePermissions->merge($userPermissions)->toArray());
    }
}
