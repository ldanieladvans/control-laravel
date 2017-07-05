<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appaccount;
use App\Appcontrol;
use App\Package;
use App\Account;
use App\Packageassignation;
use Illuminate\Support\Facades\DB;

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
        //This allow only to apps users
        $this->middleware('role:app');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appctas = Appaccount::all();
        $apps = config('app.advans_apps');

        return view('appviews.appctashow',['appctas'=>$appctas,'apps'=>$apps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        //$accounts = Account::all();
        $accounts = Account::where('cta_estado','=','Activa')->get();
        $apps = config('app.advans_apps');
        return view('appviews.appctacreate',['packages'=>$packages,'accounts'=>$accounts,'apps'=>$apps]);
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

        $apps = false;

        $packs = array();

        $apps_ret = array();

        $appcta_cuenta_id = 0;
        $appcta_paq_id = 0;

        if(array_key_exists('apps',$alldata)){
            if(isset($alldata['apps']) && $alldata['apps'] != ''){
                $apps = $alldata['apps'];
                unset($alldata['apps']);
            }
        }
        
        $apps_conf = config('app.advans_apps');
        if(array_key_exists('appcta_cuenta_id',$alldata)){
            if($alldata['appcta_cuenta_id']==''){
                unset($alldata['appcta_cuenta_id']);
            }else{
                $appcta_cuenta_id = $alldata['appcta_cuenta_id'];
            }
        }

        if(array_key_exists('appcta_paq_id',$alldata)){
            if($alldata['appcta_paq_id']==''){
                unset($alldata['appcta_paq_id']);
            }else{
                $appcta_paq_id = $alldata['appcta_paq_id'];
            }
        }

        $exist_acc = Appaccount::where('appcta_cuenta_id',$appcta_cuenta_id)->where('appcta_paq_id',$appcta_paq_id)->get();

        if(isset($exist_acc)){
            $fmessage = 'Ya existe una asignación con estos datos.';
            \Session::flash('message',$fmessage);
        }else{
            $appcta = new Appaccount($alldata);

            $appcta->appcta_app = $alldata['appcta_app'];


            $appcta->appcta_f_vent = date('Y-m-d');

            if(array_key_exists('appcta_f_fin',$alldata)){
                if($alldata['appcta_f_fin']==''){
                    $appcta->appcta_f_fin = date('Y-m-d');
                }else{
                    $appcta->appcta_f_fin = $alldata['appcta_f_fin'];
                }
            }

            if(array_key_exists('appcta_f_caduc',$alldata)){
                if($alldata['appcta_f_caduc']==''){
                    $appcta->appcta_f_caduc = date('Y-m-d');
                }else{
                    $appcta->appcta_f_caduc = $alldata['appcta_f_caduc'];
                }
            }

            $appcta->appcta_estado = 'Activa';
            $appcta->save();

            array_push($packs,[
                                    'paqapp_cantrfc'=>$appcta->appcta_rfc,
                                    'paqapp_cantgig'=>$appcta->appcta_gig,
                                    'paqapp_f_venta'=>$appcta->appcta_f_vent,
                                    'paqapp_f_act'=>date('Y-m-d'),
                                    'paqapp_f_fin'=>$appcta->appcta_f_fin,
                                    'paqapp_f_caduc'=>$appcta->appcta_f_caduc,
                                    'paqapp_control_id'=>$appcta->id,
                                    ]);

            


            if($apps!=false){
                foreach ($apps as $key => $value) {
                    $appc = new Appcontrol();
                    $appc->app_nom = $apps_conf[$value];
                    $appc->app_code = $value;
                    $appc->app_appcta_id = $appcta->id;
                    $appc->save();
                    array_push($apps_ret,['app_cod'=>$value,'app_nom'=>$apps_conf[$value]]);
                }
            }

            $arrayparams['rfc_nombrebd'] = $appcta->account ? $appcta->account->cta_num : $client_rfc;
            $arrayparams['client_rfc'] = $appcta->account ? $appcta->account->cta_num : '';
            $arrayparams['client_email'] = $appcta->account->client ? $appcta->account->client->cliente_correo : '';

            $arrayparams['client_name'] = $appcta->account->client ? $appcta->account->client->cliente_nom : $client_rfc;
            $arrayparams['client_nick'] = count(explode('@',$arrayparams['client_email'])) > 1 ? explode('@',$arrayparams['client_email'])[0] : '';

            $arrayparams['account_id'] = $appcta ? $appcta->id : 'false';
            $arrayparams['apps_cta'] = json_encode($apps_ret);
            $arrayparams['paq_cta'] = json_encode($packs);


            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'addpaq',$arrayparams,'ctac');

            $fmessage = 'Se ha asignado un paquete a una cuenta con nombre: '.$alldata['appcta_app'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'store',$fmessage);
        }

        
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
        //$accounts = Account::all();
        $accounts = Account::where('cta_estado','=','Activa')->get();
        $apps = config('app.advans_apps');

        $gig_rfc = $this->getgigrfcbypackaux($id);

        return view('appviews.appctaedit',['packages'=>$packages,'accounts'=>$accounts,'appcta'=>$appcta,'apps'=>$apps,'gig'=>$gig_rfc['gig'],'rfc'=>$gig_rfc['rfc']]);
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

        $apps = config('app.advans_apps');
        $alldata = $request->all();
        $packs = array();
        $arrayparams = array();

        /*echo "<pre>";
        print_r($alldata);die();
        echo "</pre>";*/

        $appcta = Appaccount::findOrFail($id);
        $appcta->appcta_app = $alldata['appcta_app'];
        $appcta->appcta_rfc = $alldata['appcta_rfc'];
        $appcta->appcta_gig = $alldata['appcta_gig'];
        /*$appcta->appcta_f_vent = $alldata['appcta_f_vent'];
        $appcta->appcta_f_act = $alldata['appcta_f_act'];*/
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

        //For updating apps
        /*DB::table('app')->where('app_appcta_id', '=', $appcta->id)->delete();

        if(array_key_exists('apps',$alldata) && isset($alldata['apps'])){
            foreach ($alldata['apps'] as $key => $value) {
                $appc = new Appcontrol();
                $appc->app_nom = $apps[$value];
                $appc->app_code = $value;
                $appc->app_appcta_id = $appcta->id;
                $appc->save();
            }
        }*/

        array_push($packs,[
                        'paqapp_cantrfc'=>$appcta->appcta_rfc,
                        'paqapp_cantgig'=>$appcta->appcta_gig,
                        'paqapp_f_venta'=>$appcta->appcta_f_vent,
                        'paqapp_f_act'=>$appcta->appcta_f_act,
                        'paqapp_f_fin'=>$appcta->appcta_f_fin,
                        'paqapp_f_caduc'=>$appcta->appcta_f_caduc,
                        'paqapp_control_id'=>$appcta->id,
                        ]);
        $client_rfc = $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_rfc : '') : '';

        //$arrayparams['rfc_nombrebd'] = $client_rfc.'_'.$appcta->id;
        $arrayparams['rfc_nombrebd'] = ($appcta->account ? $appcta->account->cta_num : '').'_'.$appcta->id;
        $arrayparams['account_id'] = $appcta ? $appcta->id : 'false';
        $arrayparams['paq_cta'] = json_encode($packs);

        $acces_vars = $this->getAccessToken();
        $service_response = $this->getAppService($acces_vars['access_token'],'modpaq',$arrayparams,'ctac');

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


    public function getgigrfcbypackacc(Request $request)
    {
        $alldata = $request->all();

        $paqid = false;
        $accid = false;
        $rfc = 0;
        $gig = 0;
        $counter_assig_rfc = 0;
        $counter_assig_gig = 0;
        $return_rfc = 0;
        $return_gig = 0;
        $acc_obj = false;

        $asig_distrib_rfc = 0;
        $asig_distrib_gig = 0;

        $client_rfc = false;

        $return_array = array();

        $distrib = false;

        if(array_key_exists('paqid',$alldata) && isset($alldata['paqid'])){
            $paqid = $alldata['paqid'];

        }

        if($paqid!=false){            

            if(array_key_exists('accid',$alldata) && isset($alldata['accid'])){
                $accid = $alldata['accid'];
            }
        }

        if($accid!=false && $paqid!=false){

            $paq_obj = Package::find($paqid);
            $acc_obj = Account::find($accid);

            $rfc = $paq_obj->paq_rfc;
            $gig = $paq_obj->paq_gig;

            $prevassignations = Appaccount::where('appcta_cuenta_id','=',$accid)->get();
            foreach ($prevassignations as $prevassignation) {
                $counter_assig_rfc += $prevassignation->appcta_rfc;
                $counter_assig_gig += $prevassignation->appcta_gig;
            }

            /*echo "<pre>";
            print_r($rfc);die();
            echo "</pre>";*/

            if($acc_obj!=false){
                $distrib = $acc_obj->distributor ? $acc_obj->distributor : false;

                $client_rfc = $acc_obj->client ? $acc_obj->client->cliente_rfc : '';

                if($distrib!=false){

                    $distribassignations = Packageassignation::where('asigpaq_distrib_id','=',$distrib->id)->get();

                    foreach ($distribassignations as $distribassignation) {
                        $asig_distrib_rfc += $distribassignation->asigpaq_rfc;
                        $asig_distrib_gig += $distribassignation->asigpaq_gig;
                    }
                    $rfc_assigs = ($distrib->distrib_limitrfc + ($asig_distrib_rfc - $counter_assig_rfc));
                    $gig_assigs = ($distrib->distrib_limitgig + ($asig_distrib_gig - $counter_assig_gig));
                    if($rfc <= $rfc_assigs){
                        $return_rfc = $rfc;
                    }else{
                        $return_rfc = $rfc_assigs;
                    }
                    if($gig <= $gig_assigs){
                        $return_gig = $gig;
                    }else{
                        $return_gig = $gig_assigs;
                    }
                }
            }
        }

        $params_service = array();
        if($distrib!=false){
            $params_service['rfc_nombrebd'] = $distrib->distrib_rfc;
        }
         

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'gig' => $return_gig ,
            'rfc' => $return_rfc,
        );
        return \Response::json($response);
    }



    private function getgigrfcbypackaux($id)
    {

        $paqid = false;
        $accid = false;
        $rfc = 0;
        $gig = 0;
        $counter_assig_rfc = 0;
        $counter_assig_gig = 0;
        $return_rfc = 0;
        $return_gig = 0;
        $acc_obj = false;

        $asig_distrib_rfc = 0;
        $asig_distrib_gig = 0;

        $client_rfc = false;

        $return_array = array();

        $distrib = false;

        $this_model = Appaccount::findOrFail($id);



        $paq_obj = $this_model->package ? $this_model->package : false;

        if($paq_obj!=false){            
            $acc_obj = $this_model->account ? $this_model->account : false;
        }

        if($acc_obj!=false && $paq_obj!=false){

            $rfc = $paq_obj->paq_rfc;
            $gig = $paq_obj->paq_gig;

            $prevassignations = Appaccount::where('appcta_cuenta_id','=',$acc_obj->id)->get();
            foreach ($prevassignations as $prevassignation) {
                $counter_assig_rfc += $prevassignation->appcta_rfc;
                $counter_assig_gig += $prevassignation->appcta_gig;
            }



            if($acc_obj!=false){
                $distrib = $acc_obj->distributor ? $acc_obj->distributor : false;

                $client_rfc = $acc_obj->client ? $acc_obj->client->cliente_rfc : '';

                if($distrib!=false){

                    $distribassignations = Packageassignation::where('asigpaq_distrib_id','=',$distrib->id)->get();

                    foreach ($distribassignations as $distribassignation) {
                        $asig_distrib_rfc += $distribassignation->asigpaq_rfc;
                        $asig_distrib_gig += $distribassignation->asigpaq_gig;
                    }
                    $rfc_assigs = ($distrib->distrib_limitrfc + ($asig_distrib_rfc - $counter_assig_rfc));
                    $gig_assigs = ($distrib->distrib_limitgig + ($asig_distrib_gig - $counter_assig_gig));
                    if($rfc <= $rfc_assigs){
                        $return_rfc = $rfc;
                    }else{
                        $return_rfc = $rfc_assigs;
                    }
                    if($gig <= $gig_assigs){
                        $return_gig = $gig;
                    }else{
                        $return_gig = $gig_assigs;
                    }
                }
            }
        }


        return array('gig' => $return_gig,
                    'rfc' => $return_rfc);   

    }


    public function changeAccountState(Request $request)
    {

        $client_rfc = '';
        $apps = array();
        $packs = array();
        $appcta = false;

        $state_var = 'Inactiva';

        $arrayparams = array();

        $fmessage = 'Se ha desactivado una cuenta';

        $alldata = $request->all();

        if(array_key_exists('appctaid',$alldata) && isset($alldata['appctaid'])){
            $appcta = Appaccount::findOrFail($alldata['appctaid']);
            array_push($packs,[
                                'paqapp_cantrfc'=>$appcta->appcta_rfc,
                                'paqapp_cantgig'=>$appcta->appcta_gig,
                                'paqapp_f_venta'=>$appcta->appcta_f_vent,
                                'paqapp_f_act'=>date('Y-m-d'),
                                'paqapp_f_fin'=>$appcta->appcta_f_fin,
                                'paqapp_f_caduc'=>$appcta->appcta_f_caduc,
                                'paqapp_control_id'=>$appcta->id,
                                ]);
        }

        if(array_key_exists('accstate',$alldata) && $alldata['accstate'] == 'Activa'){

            

            if($appcta!=false){
                $client_rfc = $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_rfc : '') : '';
            }

            if($client_rfc!=''){
                $apps_aux = $appcta->apps ? $appcta->apps : [];
                foreach ($apps_aux as $app_aux) {
                    array_push($apps,['app_cod'=>$app_aux->app_code,'app_nom'=>$app_aux->app_nom]);
                }

            }

            $client_mail = $appcta->account->client ? $appcta->account->client->cliente_correo : $client_rfc;
            $client_nick = $client_rfc;

            if (strpos($client_mail, '@') !== false) {
                $client_nick = explode('@',$client_mail)[0];
            }

            $arrayparams['rfc_nombrebd'] = $appcta->account ? $appcta->account->cta_num : $client_rfc;
            $arrayparams['client_rfc'] = $client_rfc;
            $arrayparams['client_email'] = $client_mail;

            $arrayparams['client_name'] = $appcta->account->client ? $appcta->account->client->cliente_nom : $client_rfc;
            $arrayparams['client_nick'] = $client_nick;

            $arrayparams['account_id'] = $appcta ? $appcta->id : 'false';
            $arrayparams['apps_cta'] = json_encode($apps);
            $arrayparams['paq_cta'] = json_encode($packs);


            $acces_vars = $this->getAccessToken();
            $service_response = $this->getAppService($acces_vars['access_token'],'addpaq',$arrayparams,'ctac');

            $fmessage = 'Se ha activado una cuenta';
            $state_var = 'Activa';
        }

        if($appcta!=false){
            $appcta->appcta_estado = $state_var;
            $appcta->save();
        }

        if($state_var=='Activa'){
            $appcta->appcta_f_act = date('Y-m-d');
            $appcta->save();
        }

        
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }



    public function assignApps(Request $request)
    {

        $alldata = $request->all();
        $rfc = '';
        $appcta_id = '';

        $array_apps = array();

        $apps = config('app.advans_apps');

        $testmsg = 'no entro';
        

        if(array_key_exists('appctaid',$alldata) && isset($alldata['appctaid'])){
            $appcta = Appaccount::findOrFail($alldata['appctaid']);
            $rfc = $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_rfc : '') : '';

            $appcta_id = $appcta->id;

            //$deletedRows = Appcontrol::where('app_appcta_id', $appcta->id)->delete();
            if(array_key_exists('selected',$alldata)){

                foreach ($alldata['selected'] as $key => $value) {
                    array_push($array_apps,['app_cod'=>$value,'app_nom'=>$apps[$value]]);
                }

                //$arrayparams['rfc_nombrebd'] = $rfc.'_'.$appcta->id;
                $arrayparams['rfc_nombrebd'] = ($appcta->account ? $appcta->account->cta_num : '');
                $arrayparams['account_id'] = $appcta ? $appcta->id : 'false';
                $arrayparams['apps_cta'] = json_encode($array_apps);
                $acces_vars = $this->getAccessToken();
                $service_response = $this->getAppService($acces_vars['access_token'],'addapp',$arrayparams,'ctac');
                $testmsg = 'entro';
                foreach ($alldata['selected'] as $key => $value) {
                    $appc = new Appcontrol();
                    $appc->app_nom = $apps[$value];
                    $appc->app_code = $value;
                    $appc->app_appcta_id = $appcta->id;
                    $appc->save();
                }
                
            }
        }

        $fmessage = 'Se han añadido nuevas aplicaciones';
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'app' => $appcta_id,
            'testmsg'=> $testmsg
        );
        return \Response::json($response);
    }


    public function quitApps(Request $request)
    {

        $alldata = $request->all();
        $rfc = '';
        $appcta_id = '';

        $array_apps = array();

        $apps = config('app.advans_apps');
        

        if(array_key_exists('appctaid',$alldata) && isset($alldata['appctaid'])){
            $appcta = Appaccount::findOrFail($alldata['appctaid']);
            $rfc = $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_rfc : '') : '';

            $appcta_id = $appcta->id;

            //$deletedRows = Appcontrol::where('app_appcta_id', $appcta->id)->delete();
            if(array_key_exists('selected',$alldata)){

                foreach ($alldata['selected'] as $key => $value) {
                    array_push($array_apps,['app_cod'=>$value,'app_nom'=>$apps[$value]]);
                }

                //$arrayparams['rfc_nombrebd'] = $rfc.'_'.$appcta->id;
                $arrayparams['rfc_nombrebd'] = ($appcta->account ? $appcta->account->cta_num : '');
                $arrayparams['account_id'] = $appcta ? $appcta->id : 'false';
                $arrayparams['apps_cta'] = json_encode($array_apps);
                $acces_vars = $this->getAccessToken();
                $service_response = $this->getAppService($acces_vars['access_token'],'desactapp',$arrayparams,'ctac');
                $testmsg = 'entro';
                foreach ($alldata['selected'] as $key => $value) {
                    \DB::table('app')->where('app_appcta_id',$appcta_id)->where('app_code',$value)->delete();
                }
                
            }
        }

        $fmessage = 'Se han eliminado aplicaciones';
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'delete',$fmessage);

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'app' => $appcta_id
        );
        return \Response::json($response);
    }


    public function getApssByAssig(){
        return Appcontrol::where('app_appcta_id',$this->id)->get();
    }



    


    
}
