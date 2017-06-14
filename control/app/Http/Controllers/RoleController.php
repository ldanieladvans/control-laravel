<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('appviews.roleshow',['roles'=>$roles,'permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('appviews.rolecreate',['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('role.index');
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
        $rol = Role::findOrFail($id);
        $permissions = Permission::all();


        return view('appviews.roledit',['permissions'=>$permissions,'rol'=>$rol]);
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
        $this->registeredBinnacle($request,'update',$fmessage);
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rol_id,Request $request)
    {
        if (isset($rol_id)){
            $rol = Role::findOrFail($rol_id);
            $fmessage = 'Se ha eliminado el rol: '.$rol->name;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'destroy',$fmessage);
            $rol->delete();

        }
        return redirect()->route('role.index');
    }

    public function assignPerm(Request $request)
    {
        $alldata = $request->all();
        $return_array = array();
        //print_r($alldata);
        if(array_key_exists('rol',$alldata) && isset($alldata['rol'])){
            $role = Role::find($alldata['rol']);
            $role->detachAllPermissions();
            if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){
                
                foreach ($alldata['selected'] as $select) {
                    $role->attachPermission($select);
                }
            }
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Se asignaron los permisos satisfactoriamente',
            'rol' => $alldata['rol'] ? $alldata['rol']:'false',
        );
        return \Response::json($response);
    }
}
