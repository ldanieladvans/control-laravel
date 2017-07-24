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
use Illuminate\Support\Facades\Auth;


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
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->usrc_super){
            $accounts = Account::all();
        }else{
            $accounts = Account::where('cta_distrib_id',$logued_user->usrc_distrib_id)->get();
        }
        
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
        $logued_user = Auth::user();
        $cta = new Account($alldata);
        $cta->save();

        $fmessage = 'Se ha creado la cuenta: '.$alldata['cta_num'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request->all(), 'store', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');

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
        if(!$this->controllerUserCanAccess(Auth::user(),$account->cta_distrib_id)){
            return view('errors.403');
        }
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->usrc_super){
            $clients = Client::all();
            $distributors = Distributor::all();
        }else{
            $clients = Client::where('cliente_distrib_id',$logued_user->usrc_distrib_id)->orWhere('cliente_distrib_id', null)->get();
            $distributors = [Distributor::findOrFail($logued_user->usrc_distrib_id)];
        }
        
        $packages = Package::all();
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
        $logued_user = Auth::user();
        //$account->cta_num = $request->cta_num;
        //$account->cta_nomservd = $request->cta_nomservd;
        //$account->cta_fecha = $request->cta_fecha;
        //$account->cta_nom_bd = $request->cta_nom_bd;
        //$account->cta_cliente_id = $request->cta_cliente_id;
        //$account->cta_distrib_id = $request->cta_distrib_id;
        //$account->cta_estado = $request->cta_estado;
        if(!$this->controllerUserCanAccess(Auth::user(),$account->cta_distrib_id)){
            return view('errors.403');
        }
        $account->cta_periodicity = $request->cta_periodicity;
        $account->cta_recursive = $request->cta_periodicity;
        $account->save();
        $fmessage = 'Se ha actualizado la cuenta: '.$request->cta_num;
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
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
        $logued_user = Auth::user();
        if (isset($account)){
            if(!$this->controllerUserCanAccess(Auth::user(),$account->cta_distrib_id)){
                return view('errors.403');
            }
            $fmessage = 'Se ha eliminado la cuenta: '.$account->cta_num;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            $account->delete();

        }
        return redirect()->route('account.index');
    }

    public function changeAccState(Request $request)
    {
        $logued_user = Auth::user();
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
                /*$app_cta = new Appaccount();
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
                $app_cta->save();*/

                /*$acctl = new AccountTl();
                $acctl->acctl_f_ini = date('Y-m-d');
                $fecha = date_create(date('Y-m-d'));
                $aux_months = $account ? $account->cta_periodicity : '1';
                date_add($fecha, date_interval_create_from_date_string($aux_months.' months'));
                $acctl->acctl_f_fin = date_format($fecha, 'Y-m-d');
                $acctl->acctl_f_corte = date_format($fecha, 'Y-m-d');
                $acctl->cta_id = $account->id;
                $acctl->acctl_estado = 'Pendiente';
                $acctl->save();*/

                $cliente_correo = $account->client ? $account->client->cliente_correo : false;
                if ($cliente_correo){
                    $aaa = 1;
                    //TODO Descomentar cuando se desbloquee el puerto 587
                    Mail::to($cliente_correo)->send(new ClientCreate(['user'=>$cliente_correo,'password'=>$password]));
                }
                
            }

            $apps = array();
            $apps_aux = Appcontrol::where('app_cta_id', $account->id)
                       ->orderBy('id', 'desc')
                       ->get();

            foreach ($apps_aux as $app_aux) {
                array_push($apps,['app_cod'=>$app_aux->app_code,'app_nom'=>$app_aux->app_nom,'app_insts'=>$app_aux->appcta->appcta_rfc,'app_megs'=>$app_aux->appcta->appcta_gig,'app_estado'=>$app_aux->appcta->sale_estado]);
            }

            $tls_array = array();
            $tls = AccountTl::where('cta_id', $account->id)
                       ->orderBy('id', 'desc')
                       ->get();
            foreach ($tls as $tl) {
                array_push($tls_array, ['paqapp_f_venta'=>$tl->acctl_f_ini,'paqapp_f_fin'=>$tl->acctl_f_fin,'paqapp_f_caduc'=>$tl->acctl_f_corte,'paqapp_control_id'=>$tl->id]);
            }

            $account->cta_fecha = date("Y-m-d");
            $account->save();
            $arrayparams['rfc_nombrebd'] = $account->cta_num ? $account->cta_num : '';
            $arrayparams['client_rfc'] = $account->client ? $account->client->cliente_rfc : '';
            $arrayparams['client_email'] = $account->client ? $account->client->cliente_correo : '';
            $arrayparams['client_name'] = $account->client ? $account->client->cliente_nom : '';
            $arrayparams['apps_cta'] = json_encode($apps);
            $arrayparams['paq_cta'] = json_encode($tls_array);
            $arrayparams['client_nick'] = count(explode('@',$arrayparams['client_email'])) > 1 ? explode('@',$arrayparams['client_email'])[0] : '';
            $arrayparams['account_id'] = $account->id;

            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'createbd',$arrayparams,'ctac');
            $this->registeredBinnacle($arrayparams, 'service', 'Se ha creado una nueva cuenta en la app de cuenta', $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
        }
        

        if($account!=false){
            $fmessage = 'El estado de la cuenta: '.$account->cta_num.' cambió a: '.$account->cta_estado;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
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
        $logued_user = Auth::user();
        $alldata = $request->all();
        $arrayparams = array();

        if(array_key_exists('userid',$alldata) && isset($alldata['userid'])){
            $arrayparams['user_id'] = $alldata['userid'];
            $arrayparams['dbname'] = $alldata['rfc'];
            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'unlockusr',$arrayparams,'ctac');
            $this->registeredBinnacle($request->all(), 'service', 'Se ha desbloqueado el usuario con id: '.$alldata['userid'].' de la cuenta'.$alldata['rfc'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
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
        $logued_user = Auth::user();
        $input = filter_input_array(INPUT_POST);

        $cta_obj = false;

        //$apps = config('app.advans_apps');
        $apps = Apps::all();

        if(array_key_exists('objid',$input)){
            $cta_obj = Account::find($input['objid']);
        }

        if(array_key_exists('id',$input)){
            $app_cta = Appaccount::find($input['id']);
        }

        if ($input['action'] == 'edit') {
            
            $fmessage = 'Se ha modificado un detalle de la cuenta: '.$app_cta->appcta_app;
            if($app_cta){
                $app_cta->appcta_rfc = $input['appcta_rfc'] ? $input['appcta_rfc'] : 0;
                $app_cta->appcta_gig = $input['appcta_gig'] ? $input['appcta_gig'] : 0;
                //\DB::table('app')->where('app_appcta_id', '=', $input['id'])->delete();
                
            }else{
                $fmessage = 'Se ha creado un detalle de la cuenta: '.$app_cta->appcta_app;
                $app_cta = new Appaccount();
                $app_cta->appcta_rfc = $input['appcta_rfc'] ? $input['appcta_rfc'] : 0;
                $app_cta->appcta_gig = $input['appcta_gig'] ? $input['appcta_gig'] : 0;
                $app_cta->appcta_f_vent = date('Y-m-d');
                $app_cta->appcta_distrib_id = $cta_obj->cta_distrib_id;
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
                /*$app_cta->appcta_f_act = date('Y-m-d');
                $app_cta->appcta_estado = 'Activa';
                $aux_state = 'Activa';
                $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
                $arrayparams['account_id'] = $cta_obj->id;
                $arrayparams['apps_cta'] = json_encode([['app_cod'=>$app_cta->apps[0]->app_code,'app_nom'=>$app_cta->apps[0]->app_nom]]);
                $acces_vars = $this->getAccessToken();
                $service_response = $this->getAppService($acces_vars['access_token'],'addapp',$arrayparams,'ctac');*/ 
            }
            $app_cta->sale_estado = $sale_estado;
            $app_cta->save();

            $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
            $arrayparams['account_id'] = $cta_obj->id;
            $arrayparams['apps_cta'] = json_encode([['app_insts'=>$app_cta->appcta_rfc,'app_megs'=>$app_cta->appcta_gig,'app_estado'=>$app_cta->sale_estado,'app_cod'=>$app_cta->apps[0]->app_code,'app_nom'=>$app_cta->apps[0]->app_nom]]);
            if($cta_obj->cta_fecha){
                $acces_vars = $this->getAccessToken();
                $service_response = $this->getAppService($acces_vars['access_token'],'modapp',$arrayparams,'ctac');
                $this->registeredBinnacle($arrayparams, 'service', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            }
            //\Session::flash('message',$fmessage);
            
            
        } else if ($input['action'] == 'delete') {
            
            $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
            $arrayparams['account_id'] = $cta_obj->id;
            $arrayparams['apps_cta'] = json_encode([['app_insts'=>$app_cta->appcta_rfc,'app_megs'=>$app_cta->appcta_gig,'app_estado'=>$app_cta->sale_estado,'app_cod'=>$app_cta->apps[0]->app_code,'app_nom'=>$app_cta->apps[0]->app_nom]]);
            $app_nom = $app_cta->apps[0]->app_nom;
            if($cta_obj->cta_fecha){
                $acces_vars = $this->getAccessToken();
                $service_response = $this->getAppService($acces_vars['access_token'],'delapp',$arrayparams,'ctac');
            
                if($service_response['status']=='success'){
                    \DB::table('app')->where('app_appcta_id', $app_cta->id)->delete(); 
                    $app_cta->delete();
                    $this->registeredBinnacle($arrayparams, 'service', 'Se ha eliminado la aplicación '.$app_nom.' de la cuenta '.$arrayparams['rfc_nombrebd'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');

                }else{
                    \Session::flash('message',$service_response['msg']);
                }
            }else{
                $app_cta->delete();
            }
            
            /*$app_cta = Appaccount::where('appcta_cuenta_id', $cta_obj->id)->get();
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
            }*/
            
        }else{
                      
            if($app_cta->appcta_estado=='Activa'){
                $aux_state = 'Inactiva';
                $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
                $arrayparams['account_id'] = $cta_obj->id;
                $arrayparams['apps_cta'] = json_encode([['app_cod'=>$app_cta->apps[0]->app_code,'app_nom'=>$app_cta->apps[0]->app_nom]]);
                if($cta_obj->cta_fecha){
                    $acces_vars = $this->getAccessToken();
                    $service_response = $this->getAppService($acces_vars['access_token'],'desactapp',$arrayparams,'ctac');
                    $this->registeredBinnacle($arrayparams, 'service', 'Se ha desactivado la aplicación '.$app_cta->apps[0]->app_nom.' de la cuenta '.$arrayparams['rfc_nombrebd'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                }
            }else{
                $app_cta->appcta_f_act = date('Y-m-d');
                $aux_state = 'Activa';
                $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
                $arrayparams['account_id'] = $cta_obj->id;
                $arrayparams['apps_cta'] = json_encode([['app_cod'=>$app_cta->apps[0]->app_code,'app_nom'=>$app_cta->apps[0]->app_nom]]);
                if($cta_obj->cta_fecha){
                    $acces_vars = $this->getAccessToken();
                    $service_response = $this->getAppService($acces_vars['access_token'],'addapp',$arrayparams,'ctac');
                    $this->registeredBinnacle($arrayparams, 'service', 'Se ha activado la aplicación '.$app_cta->apps[0]->app_nom.' de la cuenta '.$arrayparams['rfc_nombrebd'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                } 
            }
            $app_cta->appcta_estado = $aux_state;

            $this->registeredBinnacle($request->all(), 'update', 'Se ha modificado la cuenta '.$app_cta->appcta_app, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            
            $app_cta->save();
        }


        return json_encode($input);
    }

    public function addTl(Request $request)
    {
        $alldata = $request->all();
        $logued_user = Auth::user();
        $acc_id = false;
        $response = array(
            'status' => 'failure',
        );
        if(array_key_exists('accid',$alldata)){
            $acc_id = $alldata['accid'];
            $cta_obj = Account::find($alldata['accid']);
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
            if($alldata['tlid']!='false'){
                $acctl = AccountTl::find($alldata['tlid']);
                $acctl->acctl_f_ini = $f_ini;
                $acctl->acctl_f_fin = $f_fin;
                $acctl->acctl_f_corte = $f_corte;
                $acctl->save();
                $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
                $arrayparams['account_id'] = $cta_obj->id;
                $arrayparams['paq_cta'] = json_encode([['paqapp_f_venta'=>$f_ini,'paqapp_f_fin'=>$f_fin,'paqapp_f_caduc'=>$f_corte,'paqapp_control_id'=>$alldata['tlid']]]);
                if($cta_obj->cta_fecha){
                    $acces_vars = $this->getAccessToken();
                    $service_response = $this->getAppService($acces_vars['access_token'],'modpaq',$arrayparams,'ctac');
                    $this->registeredBinnacle($arrayparams, 'service', 'Se ha modificado la linea de tiempo con id: '.$alldata['tlid'].' de la cuenta '.$arrayparams['rfc_nombrebd'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                }
                
            }else{
                $acctl = new AccountTl();
                $acctl->acctl_estado = 'Pendiente';
                $acctl->cta_id = $alldata['accid'];
                $acctl->acctl_f_ini = $f_ini;
                $acctl->acctl_f_fin = $f_fin;
                $acctl->acctl_f_corte = $f_corte;
                $acctl->save();
                $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
                $arrayparams['account_id'] = $cta_obj->id;
                $arrayparams['paq_cta'] = json_encode([['paqapp_f_venta'=>$f_ini,'paqapp_f_fin'=>$f_fin,'paqapp_f_caduc'=>$f_corte,'paqapp_control_id'=>$acctl->id]]);
                if($cta_obj->cta_fecha){
                    $acces_vars = $this->getAccessToken();
                    $service_response = $this->getAppService($acces_vars['access_token'],'addpaq',$arrayparams,'ctac');
                    $this->registeredBinnacle($arrayparams, 'service', 'Se ha creado una nueva linea de tiempo con id: '.$acctl->id.' a la cuenta '.$arrayparams['rfc_nombrebd'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                }
            }

            $this->registeredBinnacle($request->all(), 'update', 'Se ha modificado la cuenta '.$cta_obj->cta_num, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');

            $response = array(
                'status' => 'success',
                'msg' => 'Ok',
                'acctl_f_ini' => $acctl->acctl_f_ini,
                'acctl_f_fin' => $acctl->acctl_f_fin,
                'acctl_f_corte' => $acctl->acctl_f_corte,
                'acctl_f_fin_next' => date('Y-m-d', strtotime($acctl->acctl_f_fin . ' +1 day')),
                'acctl_f_corte_next' => date('Y-m-d', strtotime($acctl->acctl_f_corte . ' +1 day')),
                'acctl_estado' => $acctl->acctl_estado,
                'acctl_f_pago' => '',
                'id' => $acctl->id,
                'tlid' => $alldata['tlid'],
                'alldata' => $alldata,
                'accid' => $acc_id
            );
            
        }
        
        
        return \Response::json($response);
    }

    public function quitTl(Request $request)
    {
        $response = array(
            'status' => 'failure',
        );
        $alldata = $request->all();
        if(array_key_exists('accid',$alldata)){
            $cta_obj = Account::find($alldata['accid']);
            if(array_key_exists('tlid',$alldata)){
                $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
                $arrayparams['account_id'] = $cta_obj->id;
                $arrayparams['paq_cta'] = json_encode([['paqapp_control_id'=>$alldata['tlid']]]);
                if($cta_obj->cta_fecha){
                    $acces_vars = $this->getAccessToken();
                    $service_response = $this->getAppService($acces_vars['access_token'],'delpaq',$arrayparams,'ctac');
                    $this->registeredBinnacle($arrayparams, 'service', 'Se ha eliminado un detalle de la cuenta '.$arrayparams['rfc_nombrebd'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                }
                AccountTl::destroy($alldata['tlid']);
            }
            $this->registeredBinnacle($request->all(), 'update', 'Se ha modificado la cuenta '.$cta_obj->cta_num, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            $response = array(
                'status' => 'success',
                'msg' => 'Ok',
            );
        }
        
        
        return \Response::json($response);
    }

    public function addApp(Request $request)
    {
        $alldata = $request->all();
        $response = array(
            'status' => 'failure',
        );
        if(array_key_exists('accid',$alldata)){
            $cta_obj = Account::find($alldata['accid']);
            $app_cta = new Appaccount();
            $app_cta->appcta_rfc = $alldata['appcta_rfc'] ? $alldata['appcta_rfc'] : 0;
            $app_cta->appcta_gig = $alldata['appcta_gig'] ? $alldata['appcta_gig'] : 0;
            $app_cta->appcta_f_vent = date('Y-m-d');
            $app_cta->appcta_distrib_id = $cta_obj->cta_distrib_id;
            $fecha = date_create(date('Y-m-d'));
            $aux_months = $cta_obj ? $cta_obj->cta_periodicity : '1';
            date_add($fecha, date_interval_create_from_date_string($aux_months.' months'));
            $app_cta->appcta_f_fin = date_format($fecha, 'Y-m-d');
            $app_cta->appcta_cuenta_id = $cta_obj ? $cta_obj->id : false;
            $app_cta->appcta_app = $cta_obj ? $cta_obj->cta_num : 'false';
            $app_cta->sale_estado = 'Prueba';
            $app_cta->appcta_estado = 'Activa';
            $app_cta->appcta_f_act = date('Y-m-d');
            $appc = new Appcontrol();
            $app_aux = Apps::where('code', $alldata['app'])
                           ->orderBy('id', 'desc')
                           ->take(1)
                           ->get();
            $appc->app_nom = $app_aux[0]->name;
            $appc->app_code = $alldata['app'];
            $app_cta->save();
            $appc->app_appcta_id = $app_cta->id;
            $appc->app_cta_id = $alldata['accid'];
            $appc->save();

            $arrayparams['rfc_nombrebd'] = $cta_obj->cta_num;
            $arrayparams['account_id'] = $app_cta->id;
            $arrayparams['apps_cta'] = json_encode([['app_cod'=>$appc->app_code,'app_nom'=>$appc->app_nom,'app_insts'=>$app_cta->appcta_rfc,'app_megs'=>$app_cta->appcta_gig,'app_estado'=>'Prueba']]);
            if($cta_obj->cta_fecha){
                $acces_vars = $this->getAccessToken();
                $service_response = $this->getAppService($acces_vars['access_token'],'addapp',$arrayparams,'ctac');
                $this->registeredBinnacle($arrayparams, 'service', 'Se ha añadido la aplicación '.$appc->app_nom.' a la cuenta '.$arrayparams['rfc_nombrebd'], $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Ok',
                //'service_response' => $service_response
            );
            $this->registeredBinnacle($request->all(), 'update', 'Se ha modificado la cuenta '.$cta_obj->cta_num, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
        }
        
        
        return \Response::json($response);
    }
}
