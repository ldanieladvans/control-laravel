<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
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
        if($logued_user->usrc_admin || $logued_user->can('see.perms')){
            $permissions = Permission::all();
            return view('appviews.permissionshow',['permissions'=>$permissions]);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        if($logued_user->usrc_admin || $logued_user->can('edit.perms')){
            $permission = Permission::findOrFail($id);
            return view('appviews.permedit',['permission'=>$permission]);
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
    public function update(Request $request, $id)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.perms')){
            $alldata = $request->all();
            $permission = Permission::findOrFail($id);
            $permission->name = $alldata['name'];
            $permission->description = $alldata['description'];
            $permission->save();
            $fmessage = 'Se ha modificado el permiso: '.$alldata['name'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('permission.index');
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
    public function destroy($id)
    {
        //
    }
}
