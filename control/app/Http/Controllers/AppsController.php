<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apps;

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
        $apps = Apps::all();
        return view('appviews.appshow',['apps'=>$apps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appviews.appscreate');
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
        $app = new Apps($alldata);
        $app->save();
        $fmessage = 'Se ha creado la aplicación: '.$app->name;
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('apps.index');
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
        return view('appviews.appsedit',['app'=>$app]);
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
        $alldata = $request->all();
        $app->name = $alldata['name'];
        $app->code = $alldata['code'];
        $app->base_price = $alldata['base_price'];
        $app->trial_days = $alldata['trial_days'];
        $app->save();
        $fmessage = 'Se ha actualizado la aplicación: '.$app->name;
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);
        return redirect()->route('apps.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apps $app,Request $request)
    {
        if (isset($app)){
            $fmessage = 'Se ha eliminado el paquete: '.$app->name;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'destroy',$fmessage);
            $app->delete();
        }
        return redirect()->route('apps.index');
    }
}
