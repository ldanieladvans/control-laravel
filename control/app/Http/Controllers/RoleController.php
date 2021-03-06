<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Create a new controller instance. Validating Authentication and Role
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:app');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('see.roles')){
            $roles = Role::all();
            $permissions = Permission::all();
            return view('appviews.roleshow',['roles'=>$roles,'permissions'=>$permissions]);
        }else{
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('create.roles')){
            $permissions = Permission::all();
            return view('appviews.rolecreate',['permissions'=>$permissions]);
        }else{
            return view('errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('create.roles')){
            $alldata = $request->all();
            $permisos = false;
            if(array_key_exists('permisos',$alldata)){
                $permisos = $alldata['permisos'];
                unset($alldata['permisos']);
            }
            $rol = new Role($alldata);
            $rol->save();
            if($permisos != false){
                foreach ($permisos as $perm) {
                    $permobj = Permission::find($perm);
                    $rol->attachPermission($permobj);
                }
            }
            $fmessage = 'Se ha creado el rol: '.$alldata['name'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'store', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('role.index');
        }else{
            return view('errors.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.roles')){
            $rol = Role::findOrFail($id);
            $permissions = Permission::all();
            return view('appviews.roledit',['permissions'=>$permissions,'rol'=>$rol]);
        }else{
            return view('errors.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$rol_id)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.roles')){
            $alldata = $request->all();
            $permisos = false;
            if(array_key_exists('permisos',$alldata)){
                $permisos = $alldata['permisos'];
                unset($alldata['permisos']);
            }
            $rol = Role::findOrFail($rol_id);
            $rol->name = $alldata['name'];
            $rol->slug = $alldata['slug'];
            $rol->description = $alldata['description'];
            $rol->save();
            if($permisos != false){
                $rol->detachAllPermissions();
                foreach ($permisos as $perm) {
                    $permobj = Permission::find($perm);
                    $rol->attachPermission($permobj);
                }
            }
            $fmessage = 'Se ha actualizado el rol: '.$alldata['name'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('role.index');
        }else{
            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rol_id,Request $request)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.roles')){
            if (isset($rol_id)){
                $rol = Role::findOrFail($rol_id);
                $fmessage = 'Se ha eliminado el rol: '.$rol->name;
                \Session::flash('message',$fmessage);
                $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                $rol->delete();

            }
            return redirect()->route('role.index');
        }else{
            return view('errors.403');
        }
    }

    public function assignPerm(Request $request)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('assign.perms.roles')){
            $alldata = $request->all();
            $return_array = array();
            $response = array(
                'status' => 'failure',
            );
            if(array_key_exists('rol',$alldata) && isset($alldata['rol'])){
                $role = Role::find($alldata['rol']);
                $role->detachAllPermissions();
                if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){
                    
                    foreach ($alldata['selected'] as $select) {
                        $role->attachPermission($select);
                    }
                }
                $this->registeredBinnacle($request->all(), 'update', 'Se han asignado permisos al rol con id: '.$alldata['rol'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                $response = array(
                    'status' => 'success',
                    'msg' => 'Se asignaron los permisos satisfactoriamente',
                    'rol' => $alldata['rol'] ? $alldata['rol']:'false',
                );
            }
        }else{
            $response = array(
                    'status' => 'failure',
                    'msg' => 'No tiene permiso para realizar esta accion',
                );
        }
        
        return \Response::json($response);
    }
}
