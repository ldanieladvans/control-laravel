<?php

namespace App\Http\Controllers;

use App\Account;
use App\Client;
use App\Distributor;
use App\Package;
use Illuminate\Http\Request;

class AccountController extends Controller
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
        $accounts = Account::all();
        $packages = Package::all();
        return view('appviews.accountshow',['accounts'=>$accounts,'packages'=>$packages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $distributors = Distributor::all();
        $packages = Package::all();
        return view('appviews.accountcreate',['clients'=>$clients,'distributors'=>$distributors,'packages'=>$packages]);
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
        if(array_key_exists('cta_distrib_id',$alldata)){
            if($alldata['cta_distrib_id']=='null'){
                unset($alldata['cta_distrib_id']);
            }
        }
        if(array_key_exists('cta_cliente_id',$alldata)){
            if($alldata['cta_cliente_id']=='null'){
                unset($alldata['cta_cliente_id']);
            }
        }
        $cta = new Account($alldata);
        $cta->save();
        $fmessage = 'Se ha creado la cuenta: '.$alldata['cta_num'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('account.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        $accounts = Account::all();
        return view('appviews.accountshow',['accounts'=>$accounts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //$clients = Client::where('id', '<>', $account->cta_cliente_id)->get();
        $clients = Client::all();
        $distributors = Distributor::all();
        $packages = Package::all();
        return view('appviews.accountedit',['account'=>$account,'clients'=>$clients,'distributors'=>$distributors,'packages'=>$packages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $account->cta_num = $request->cta_num;
        $account->cta_nomservd = $request->cta_nomservd;
        $account->cta_fecha = $request->cta_fecha;
        $account->cta_nom_bd = $request->cta_nom_bd;
        $account->cta_cliente_id = $request->cta_cliente_id;
        $account->cta_distrib_id = $request->cta_distrib_id;
        $account->cta_estado = $request->cta_estado;
        $account->save();
        $fmessage = 'Se ha actualizado la cuenta: '.$request->cta_num;
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);
        return redirect()->route('account.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account,Request $request)
    {
        if (isset($account)){
            $fmessage = 'Se ha eliminado la cuenta: '.$account->cta_num;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'destroy',$fmessage);
            $account->delete();

        }
        return redirect()->route('account.index');
    }


    public function changeAccState(Request $request)
    {
        $account = false;
        $alldata = $request->all();
        $return_array = array();
        if(array_key_exists('accid',$alldata) && isset($alldata['accid'])){
            $account = Account::findOrFail($alldata['accid']);
            $accid = $alldata['accid'];
            if(array_key_exists('accstate',$alldata) && isset($alldata['accstate'])){
                
                $account->cta_estado = $alldata['accstate'];
            }
        }
        $account->cta_fecha = date("Y-m-d");
        $account->save();
        if($account!=false){
            $fmessage = 'El estado de la cuenta: '.$account->cta_num.' cambió a: '.$account->cta_estado;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'update',$fmessage);
        }
        

        $response = array(
            'status' => 'success',
            'msg' => 'Se cambió el estado de la cuenta satisfactoriamente',
        );
        return \Response::json($response);
    }
}
