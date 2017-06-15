<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appaccount;
use App\Package;
use App\Account;

class AppaccountController extends Controller
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
        $appctas = Appaccount::all();
        return view('appviews.appctashow',['appctas'=>$appctas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        $accounts = Account::all();
        return view('appviews.appctacreate',['packages'=>$packages,'accounts'=>$accounts]);
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
        if(array_key_exists('appcta_cuenta_id',$alldata)){
            if($alldata['appcta_cuenta_id']==''){
                unset($alldata['appcta_cuenta_id']);
            }
        }
        $appcta = new Appaccount($alldata);
        $appcta->save();

        $fmessage = 'Se ha asignado un paquete a una cuenta con nombre: '.$alldata['appcta_app'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('appcta.index');
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
        $appcta = Appaccount::findOrFail($id);
        $packages = Package::all();
        $accounts = Account::all();


        return view('appviews.appctaedit',['packages'=>$packages,'accounts'=>$accounts,'appcta'=>$appcta]);
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
        $alldata = $request->all();
        /*echo "<pre>";
        print_r($alldata);die();
        echo "</pre>";*/
        $appcta = Appaccount::findOrFail($id);
        $appcta->appcta_app = $alldata['appcta_app'];
        $appcta->appcta_rfc = $alldata['appcta_rfc'];
        $appcta->appcta_gig = $alldata['appcta_gig'];
        $appcta->appcta_f_vent = $alldata['appcta_f_vent'];
        $appcta->appcta_f_act = $alldata['appcta_f_act'];
        $appcta->appcta_f_fin = $alldata['appcta_f_fin'];
        $appcta->appcta_f_caduc = $alldata['appcta_f_caduc'];

        if(array_key_exists('appcta_cuenta_id',$alldata) && isset($alldata['appcta_cuenta_id'])){
            if($alldata['appcta_cuenta_id']!=''){
                $appcta->appcta_cuenta_id = $alldata['appcta_cuenta_id'];
            }
        }

        if(array_key_exists('appcta_paq_id',$alldata) && isset($alldata['appcta_paq_id'])){
            if($alldata['appcta_paq_id']!='null'){
                $appcta->appcta_paq_id = $alldata['appcta_paq_id'];
            }
        }

        $appcta->save();

        $fmessage = 'Se ha actualizado un paquete - cuenta con nombre: '.$alldata['appcta_app'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('appcta.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {

        if (isset($id)){
            $appcta = Appaccount::findOrFail($id);
            $fmessage = 'Se ha eliminado la asignacion de cuenta-paquete: '.$appcta->appcta_app;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'destroy',$fmessage);
            $appcta->delete();

        }
        return redirect()->route('appcta.index');
    }
}
