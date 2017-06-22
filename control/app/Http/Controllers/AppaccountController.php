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

        if(array_key_exists('apps',$alldata)){
            if(isset($alldata['apps'])){
                $apps = $alldata['apps'];
                unset($alldata['apps']);
            }
        }
        
        $apps_conf = config('app.advans_apps');
        if(array_key_exists('appcta_cuenta_id',$alldata)){
            if($alldata['appcta_cuenta_id']==''){
                unset($alldata['appcta_cuenta_id']);
            }
        }
        $appcta = new Appaccount($alldata);


        $appcta->appcta_app = $alldata['appcta_app'];

        
        $appcta->save();


        if($apps!=false){
            foreach ($apps as $key => $value) {
                $appc = new Appcontrol();
                $appc->app_nom = $apps[$value];
                $appc->app_code = $value;
                $appc->app_appcta_id = $appcta->id;
                $appc->save();
            }
        }

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
        //$accounts = Account::all();
        $accounts = Account::where('cta_estado','=','Activa')->get();
        $apps = config('app.advans_apps');

        return view('appviews.appctaedit',['packages'=>$packages,'accounts'=>$accounts,'appcta'=>$appcta,'apps'=>$apps]);
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

        DB::table('app')->where('app_appcta_id', '=', $appcta->id)->delete();

        if(array_key_exists('apps',$alldata) && isset($alldata['apps'])){
            foreach ($alldata['apps'] as $key => $value) {
                $appc = new Appcontrol();
                $appc->app_nom = $apps[$value];
                $appc->app_code = $value;
                $appc->app_appcta_id = $appcta->id;
                $appc->save();
            }
        }

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

    private function getgigrfcbypackaux($paqid,$accid)
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

        $client = false;

        $paq_obj = Package::find($paqid);
        $acc_obj = Account::find($accid);

        $rfc = $paq_obj->paq_rfc;
        $gig = $paq_obj->paq_gig;

        $prevassignations = Appaccount::where('appcta_cuenta_id','=',$accid)->get();
        foreach ($prevassignations as $prevassignation) {
            $counter_assig_rfc += $prevassignation->asigpaq_rfc;
            $counter_assig_gig += $prevassignation->asigpaq_gig;
        }

        if($acc_obj!=false){
            $distrib = $acc_obj->distributor ? $distrib = $acc_obj->distributor : false;

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

        return array('gig' => $return_gig,
                    'rfc' => $return_rfc);   

    }


    public function getgigrfcbypack(Request $request)
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
                $acc_id = $alldata['accid'];
            }
        }

        if($acc_id!=false && $paqid!=false){

            $paq_obj = Package::find($paqid);
            $acc_obj = Account::find($acc_id);

            $rfc = $paq_obj->paq_rfc;
            $gig = $paq_obj->paq_gig;

            $prevassignations = Appaccount::where('appcta_cuenta_id','=',$acc_id)->get();
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

    public function changeAccountState(Request $request)
    {

        $client_rfc = '';
        $apps = array();
        $packs = array();
        $appcta = false;

        $arrayparams = array();

        $alldata = $request->all();

        if(array_key_exists('appctaid',$alldata) && isset($alldata['appctaid'])){
            $appcta = Appaccount::findOrFail($alldata['appctaid']);
            array_push($packs,[
                                'paqapp_cantrfc'=>$appcta->appcta_rfc,
                                'paqapp_cantgig'=>$appcta->appcta_gig,
                                'paqapp_f_venta'=>$appcta->appcta_f_vent,
                                'paqapp_f_act'=>$appcta->appcta_f_act,
                                'paqapp_f_fin'=>$appcta->appcta_f_fin,
                                'paqapp_f_caduc'=>$appcta->appcta_f_caduc,
                                'paqapp_control_id'=>$appcta->id,
                                ]);
            /*$appcta->appcta_estado = 'Activa';
            $appcta->save();*/
        }

        if($appcta!=false){
            $client_rfc = $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_rfc : '') : '';
        }

        if($client_rfc!=''){
            $apps_aux = $appcta->apps ? $appcta->apps : [];
            foreach ($apps_aux as $app_aux) {
                array_push($apps,['app_cod'=>$app_aux->app_code,'app_nom'=>$app_aux->app_nom]);
            }

        }

        $arrayparams['rfc_nombrebd'] = $client_rfc;
        $arrayparams['account_id'] = $appcta ? $appcta->id : 'false';
        $arrayparams['apps_cta'] = json_encode($apps);
        $arrayparams['paq_cta'] = json_encode($packs);

        $acces_vars = $this->getAccessToken();
        $service_response = $this->getAppService($acces_vars['access_token'],'createbd',$arrayparams,'ctac');

        /*echo "<pre>";
        print_r($service_response);die();
        echo "</pre>";*/

        if($appcta!=false){
            $appcta->appcta_estado = 'Activa';
            $appcta->save();
        }

        $fmessage = 'Se ha activado una cuenta';
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'destroy',$fmessage);

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
        return \Response::json($response);
    }


    public function getAccState(Request $request)
    {

        $client_rfc = '';
        $apps = array();
        $packs = array();
        $appcta = false;

        $arrayparams = array();

        $alldata = $request->all();

        $acc_state = 'None';

        if(array_key_exists('rfc',$alldata) && isset($alldata['rfc'])){
            $rfc_accid = split('_', $alldata['rfc']);
            if(count($rfc_accid)>=2){
                $appcta = Appaccount::findOrFail($rfc_accid[1]);
                $acc_state = $appcta->appcta_estado;
            }
            
        }


        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'accstate' => $acc_state
        );
        return \Response::json($response);
    }


    
}
