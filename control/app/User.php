<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use Notifiable, HasRoleAndPermission, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'usrc_nick', 'uscr_tel', 'usrc_super', 'usrc_ult_acces', 'usrc_activo', 'usrc_distrib_id','usrc_admin'
    ];

    //Uncomment for multibd
    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = \Session::get('selected_database','mysql');
    }*/

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


    /**
     * 
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customGetUserPerms($perm_id,$count=false)
    {

        if($count!=false){
            $perms = DB::table('permission_user')->where([
                ['permission_id', '=', $perm_id],
                ['user_id', '=', $this->id],
            ])->count();
        }else{
            $perms = DB::table('permission_user')->where([
                ['permission_id', '=', $perm_id],
                ['user_id', '=', $this->id],
            ])->get();
        }
        

        return $perms;
    }


    /**
     * 
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customPermsByUser($count=false)
    {
        if($count!=false){
            $perms = DB::table('permission_user')->where('user_id', '=', $this->id)->count();
        }else{
            $perms = DB::table('permission_user')->where('user_id', '=', $this->id)->get();
        }
        

        return $perms;
    }


    /**
     * 
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customGetRolePerms($role_id,$perm_id,$count=false)
    {

        if($count!=false){
            $perms = DB::table('permission_role')->where([
                ['permission_id', '=', $perm_id],
                ['role_id', '=', $role_id],
            ])->count();
        }else{
            $perms = DB::table('permission_role')->where([
                ['permission_id', '=', $perm_id],
                ['role_id', '=', $role_id],
            ])->get();
        }

        

        return $perms;
    }


    /**
     * 
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function customRolesByUser($count=false)
    {
        if($count!=false){
            $perms = DB::table('role_user')->where('user_id', '=', $this->id)->count();
        }else{
          $perms = DB::table('role_user')->where('user_id', '=', $this->id)->get();  
        }
        

        return $perms;
    }
}
