<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apps;
use Illuminate\Support\Facades\Auth;

class AppsController extends Controller
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
        if($logued_user->usrc_admin || $logued_user->can('see.apps')){
            $apps = Apps::all();
            return view('appviews.appshow',['apps'=>$apps]);
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
        if($logued_user->usrc_admin || $logued_user->can('create.apps')){
            return view('appviews.appscreate');
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
        if($logued_user->usrc_admin || $logued_user->can('create.apps')){
            $alldata = $request->all(); 
            $app = new Apps($alldata);
            $app->save();
            $fmessage = 'Se ha creado la aplicación: '.$app->name;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'store', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('apps.index');
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
        $apps = Apps::all();
        return view('appviews.appshow',['apps'=>$apps]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apps $app)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.apps')){
            return view('appviews.appsedit',['app'=>$app]);
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
    public function update(Request $request, Apps $app)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.apps')){
            $alldata = $request->all();
            $app->name = $alldata['name'];
            $app->code = $alldata['code'];
            $app->base_price = $alldata['base_price'];
            $app->trial_days = $alldata['trial_days'];
            $app->save();
            $fmessage = 'Se ha actualizado la aplicación: '.$app->name;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('apps.index');
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
    public function destroy(Apps $app,Request $request)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('delete.apps')){
            if (isset($app)){
                $logued_user = Auth::user();
                $fmessage = 'Se ha eliminado el paquete: '.$app->name;
                \Session::flash('message',$fmessage);
                $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                $app->delete();
            }
            return redirect()->route('apps.index');
        }else{
            return view('errors.403');
        }
    }
}
