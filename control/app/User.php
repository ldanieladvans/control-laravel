<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use InvalidArgumentException;


class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use Notifiable, HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'usrc_nick', 'uscr_tel', 'usrc_super', 'usrc_ult_acces', 'usrc_activo', 'usrc_distrib_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function distributor()
    {
        return $this->belongsTo('App\Distributor','usrc_distrib_id');
    }

    public function binnacles()
    {
        return $this->hasMany('App\Binnacle','bitc_usrc_id');
    }

    /**
     * Get all permissions from roles.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rolePermissions()
    {
        $permissionModel = app(config('roles.models.permission'));

        return $permissionModel::select(['permissions.*', 'permission_role.created_at as pivot_created_at', 'permission_role.updated_at as pivot_updated_at'])
                ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')->join('roles', 'roles.id', '=', 'permission_role.role_id')
                ->whereIn('roles.id', $this->getRoles()->pluck('id')->toArray()) ->orWhere('roles.level', '<', $this->level())
                ->groupBy(['permissions.id', 'pivot_created_at', 'pivot_updated_at', 'name', 'slug','description','model','created_at','updated_at']);
    }
}
