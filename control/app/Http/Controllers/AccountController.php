<?php

namespace App\Http\Controllers;

use App\Account;
use App\Client;
use App\Distributor;
use App\Package;
use App\Appaccount;
use Illuminate\Http\Request;

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

        $cta_distrib_id = 0;
        $cta_cliente_id = 0;
        $alldata = $request->all();

        if(array_key_exists('cta_distrib_id',$alldata)){
            if($alldata['cta_distrib_id']=='null'){
                unset($alldata['cta_distrib_id']);
            }else{
                $cta_distrib_id = $alldata['cta_distrib_id'];
            }
        }
        if(array_key_exists('cta_cliente_id',$alldata)){
            if($alldata['cta_cliente_id']=='null'){
                unset($alldata['cta_cliente_id']);
            }else{
                $cta_cliente_id = $alldata['cta_cliente_id'];
            }
        }

        $exist_account = Account::where('cta_distrib_id',$cta_distrib_id)->where('cta_cliente_id',$cta_cliente_id)->get();
        
        if(count($exist_account) > 0){
            $fmessage = 'Ya existe una cuenta para estos datos.';
            \Session::flash('message',$fmessage);
        }else{
            $cta = new Account($alldata);
            $cta->save();
            $fmessage = 'Se ha creado la cuenta: '.$alldata['cta_num'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'store',$fmessage);
        }

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
        $apps = config('app.advans_apps');
        return view('appviews.accountedit',['account'=>$account,'clients'=>$clients,'distributors'=>$distributors,'packages'=>$packages,'apps'=>json_encode($apps)]);
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

                $cliente_correo = $account->client ? $account->client->cliente_correo : false;
                if ($cliente_correo){
                    $aaa = 1;
                    //TODO Descomentar cuando se desbloquee el puerto 587
                    //Mail::to($cliente_correo)->send(new ClientCreate(['user'=>$cliente_correo,'password'=>$password]));
                }
                
            }

            $account->cta_fecha = date("Y-m-d");
            $account->save();
            $arrayparams['rfc_nombrebd'] = $account->cta_num ? $account->cta_num : '';
            $arrayparams['client_rfc'] = $account->client ? $account->client->cliente_rfc : '';
            $arrayparams['client_email'] = $account->client ? $account->client->cliente_correo : '';
            $arrayparams['client_name'] = $account->client ? $account->client->cliente_nom : '';
            $arrayparams['password'] = $password;
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

        if ($input['action'] == 'edit') {
            $app_cta = Appaccount::find($input['id']);
            $app_cta->appcta_gig = $input['appcta_gig'];
            $app_cta->save();
            //$mysqli->query("UPDATE users SET username='" . $input['username'] . "', email='" . $input['email'] . "', avatar='" . $input['avatar'] . "' WHERE id='" . $input['id'] . "'");
        } else if ($input['action'] == 'delete') {
            $app_cta = Appaccount::find($input['id']);
            //$mysqli->query("UPDATE users SET deleted=1 WHERE id='" . $input['id'] . "'");
        } else if ($input['action'] == 'restore') {
            $app_cta = Appaccount::find($input['id']);
            //$mysqli->query("UPDATE users SET deleted=0 WHERE id='" . $input['id'] . "'");
        }

        return json_encode($input);
    }
}
