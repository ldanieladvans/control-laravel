<?php

namespace App\Http\Controllers;

use App\Account;
use App\Client;
use App\Distributor;
use App\Package;
use App\Appaccount;
use App\Appcontrol;
use App\Apps;
use App\AccountTl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\ClientCreate;
use Illuminate\Support\Facades\Mail;


class AccountController extends Controller
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
        $fecha = date('Y-m-d');
        return view('appviews.accountcreate',['clients'=>$clients,'distributors'=>$distributors,'packages'=>$packages,'fecha'=>$fecha]);
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
        $clients = Client::all();
        $distributors = Distributor::all();
        $packages = Package::all();
        //$apps = config('app.advans_apps');
        $apps = Apps::all();
        $apps_array = array();
        foreach ($apps as $app) {
            $apps_array[$app->code] = $app->name;
        }
        return view('appviews.accountedit',['account'=>$account,'clients'=>$clients,'distributors'=>$distributors,'packages'=>$packages,'apps'=>json_encode($apps_array),'appsne'=>$apps]);
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
        
        $account->save();

        if($account->cta_estado == 'Activa'){
            if(!$account->cta_fecha){
                $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXWYZ0123456789!"$%&/()=?¿*/[]{}.,;:';
                $password = $this->rand_chars($caracteres,8);
                $resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);

                while(!$resultm || count($matchesm) == 0){
                    $password = $this->rand_chars($caracteres,8);
                    $resultm = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$_])[a-zA-Z\d$@$!%*?&#.$($‌​)$-$_]{8,50}$/u', $password, $matchesm);
                }

                $arrayparams['password'] = $password;
                Log::info($password);
                $app_cta = new Appaccount();
                $app_cta->appcta_rfc = 0;
                $app_cta->appcta_gig = 0;
                $app_cta->appcta_f_vent = date('Y-m-d');
                $fecha = date_create(date('Y-m-d'));
                $aux_months = $account ? $account->cta_periodicity : '1';
                date_add($fecha, date_interval_create_from_date_string($aux_months.' months'));
                $app_cta->appcta_f_fin = date_format($fecha, 'Y-m-d');
                $app_cta->appcta_cuenta_id = $account ? $account->id : false;
                $app_cta->appcta_app = $account ? $account->cta_num : 'false';
                $app_cta->appcta_estado = 'Activa';
                $app_cta->save();

                $cliente_correo = $account->client ? $account->client->cliente_correo : false;
                if ($cliente_correo){
                    $aaa = 1;
                    //TODO Descomentar cuando se desbloquee el puerto 587
                    Mail::to($cliente_correo)->send(new ClientCreate(['user'=>$cliente_correo,'password'=>$password]));
                }
                
            }

            $account->cta_fecha = date("Y-m-d");
            $account->save();
            $arrayparams['rfc_nombrebd'] = $account->cta_num ? $account->cta_num : '';
            $arrayparams['client_rfc'] = $account->client ? $account->client->cliente_rfc : '';
            $arrayparams['client_email'] = $account->client ? $account->client->cliente_correo : '';
            $arrayparams['client_name'] = $account->client ? $account->client->cliente_nom : '';
            
            $arrayparams['client_nick'] = count(explode('@',$arrayparams['client_email'])) > 1 ? explode('@',$arrayparams['client_email'])[0] : '';
            $arrayparams['account_id'] = $account->id;

            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'createbd',$arrayparams,'ctac');
        }
        

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

    public function getClientRfc(Request $request)
    {
        $alldata = $request->all();
        $rfc = '';
        if(array_key_exists('clientid',$alldata) && isset($alldata['clientid'])){
            $rfc = Client::findOrFail($alldata['clientid'])->cliente_rfc;
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
            'rfc' => $rfc
        );
        return \Response::json($response);
    }

    public function getCtaUsers(Request $request)
    {
        $alldata = $request->all();
        $arrayparams = array();

        if(array_key_exists('rfc',$alldata) && isset($alldata['rfc'])){
            $arrayparams['dbname'] = $alldata['rfc'];
            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'getusr',$arrayparams,'ctac');
        }
        
        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
            'users' => $service_response,
            'modalname' => 'ctauser'.$alldata['rfc'],
            'rfc' => $alldata['rfc']
        );
        return \Response::json($response);
    }


    public function unblockUser(Request $request)
    {
        $alldata = $request->all();
        $arrayparams = array();

        if(array_key_exists('userid',$alldata) && isset($alldata['userid'])){
            $arrayparams['user_id'] = $alldata['userid'];
            $arrayparams['dbname'] = $alldata['rfc'];
            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'unlockusr',$arrayparams,'ctac');
        }
        
        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
            'rfc' => $alldata['rfc']
        );
        return \Response::json($response);
    }

    public function getCtaBin(Request $request)
    {
        $alldata = $request->all();
        $arrayparams = array();

        if(array_key_exists('rfc',$alldata) && isset($alldata['rfc'])){
            $arrayparams['dbname'] = $alldata['rfc'];
            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'getbit',$arrayparams,'ctac');
        }
        
        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
            'bitentries' => $service_response,
            'modalname' => 'binacle'.$alldata['rfc'],
            'rfc' => $alldata['rfc']
        );
        return \Response::json($response);
    }

    public function crudTablEdit(Request $request)
    {
        $alldata = $request->all();
        $arrayparams = array();

        $input = filter_input_array(INPUT_POST);

        $cta_obj = false;

        //$apps = config('app.advans_apps');
        $apps = Apps::all();

        if(array_key_exists('objid',$input)){
            $cta_obj = Account::find($input['objid']);
        }

        if ($input['action'] == 'edit') {
            $app_cta = Appaccount::find($input['id']);
            if($app_cta){
                $app_cta->appcta_rfc = $input['appcta_rfc'] ? $input['appcta_rfc'] : 0;
                $app_cta->appcta_gig = $input['appcta_gig'] ? $input['appcta_gig'] : 0;
                \DB::table('app')->where('app_appcta_id', '=', $input['id'])->delete();
            }else{
                $app_cta = new Appaccount();
                $app_cta->appcta_rfc = $input['appcta_rfc'] ? $input['appcta_rfc'] : 0;
                $app_cta->appcta_gig = $input['appcta_gig'] ? $input['appcta_gig'] : 0;
                $app_cta->appcta_f_vent = date('Y-m-d');
                $fecha = date_create(date('Y-m-d'));
                $aux_months = $cta_obj ? $cta_obj->cta_periodicity : '1';
                date_add($fecha, date_interval_create_from_date_string($aux_months.' months'));
                $app_cta->appcta_f_fin = date_format($fecha, 'Y-m-d');
                $app_cta->appcta_cuenta_id = $cta_obj ? $cta_obj->id : false;
                $app_cta->appcta_app = $cta_obj ? $cta_obj->cta_num : 'false';
            }
            $sale_estado = 'Prueba';
            if($input['sale_estado']=='prod'){
                $sale_estado = 'Producción';
                $app_cta->appcta_f_act = date('Y-m-d');
            }
            $app_cta->sale_estado = $sale_estado;
            $appc = new Appcontrol();
            $app_aux = Apps::where('code', $input['apps'])
                           ->orderBy('id', 'desc')
                           ->take(1)
                           ->get();
            $appc->app_nom = $app_aux[0]->name;
            $appc->app_code = $input['apps'];
            $app_cta->save();
            $appc->app_appcta_id = $app_cta->id;
            $appc->save();

            $fmessage = 'Se ha creado un detalle de la cuenta: '.$app_cta->appcta_app;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'create',$fmessage);
            
        } else if ($input['action'] == 'delete') {
            $app_cta = Appaccount::find($input['id']);
            $app_cta->delete();
            $app_cta = Appaccount::where('appcta_cuenta_id', $cta_obj->id)->get();
            if(count($app_cta)==0){
                $app_cta = new Appaccount();
                $app_cta->appcta_rfc = 0;
                $app_cta->appcta_gig = 0;
                $app_cta->appcta_f_vent = date('Y-m-d');
                $fecha = date_create(date('Y-m-d'));
                $aux_months = $cta_obj ? $cta_obj->cta_periodicity : '1';
                date_add($fecha, date_interval_create_from_date_string($aux_months.' months'));
                $app_cta->appcta_f_fin = date_format($fecha, 'Y-m-d');
                $app_cta->appcta_cuenta_id = $cta_obj ? $cta_obj->id : false;
                $app_cta->appcta_app = $cta_obj ? $cta_obj->cta_num : 'false';
                $app_cta->appcta_estado = 'Activa';
                $app_cta->save();
            }
        }

        return json_encode($input);
    }

    public function addTl(Request $request)
    {
        $alldata = $request->all();
        if(array_key_exists('accid',$alldata)){
            $f_ini = date('Y-m-d');
            $fecha = date_create(date('Y-m-d'));
            date_add($fecha, date_interval_create_from_date_string('30 days'));
            $f_fin = date_format($fecha, 'Y-m-d');
            $f_corte = $f_fin;
            if(array_key_exists('f_ini',$alldata)){
                $f_ini = $alldata['f_ini'];
                $fecha = date_create($f_ini);
                date_add($fecha, date_interval_create_from_date_string('30 days'));
                $f_fin = date_format($fecha, 'Y-m-d');
                $f_corte = $f_fin;
            }
            if(array_key_exists('f_fin',$alldata)){
                $f_fin = $alldata['f_fin'];
            }
            if(array_key_exists('f_corte',$alldata)){
                $f_corte = $alldata['f_corte'];
            }
        }
        
        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
        );
        return \Response::json($response);
    }
}
