<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Binnacle;
use Illuminate\Http\Request;
use Sinergi\BrowserDetector\Browser;
use App\Munic;
use App\Cpmex;
use App\Package;
use App\Packageassignation;
use Illuminate\Support\Facades\Auth;
use App\Art69;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function registeredBinnacle($request, $fname='', $fmessage='', $user_id=null, $user_name=''){
    	$user = \Auth::user();
    	$browser = new Browser();
    	$split_var = explode('\Controllers',get_class($this));
    	$binnacle = new Binnacle();
    	$binnacle->bitc_usrc_id = $user_id;
        $binnacle->bitc_usrc_name = $user_name;
    	$binnacle->bitc_fecha = date("Y-m-d H:i:s");
    	$binnacle->bitc_tipo_op = $fname;
        $binnacle->bitc_ip = $binnacle->getrealip();
        $browser_arr = $binnacle->getBrowser();
        $binnacle->bitc_naveg = $browser_arr['name'].' '.$browser_arr['version'];
    	$binnacle->bitc_modulo = $split_var[1];
    	$binnacle->bitc_result = 'TODO';
    	$binnacle->bitc_msj = $fmessage;
    	$binnacle->bitc_dat = json_encode($request);
    	$binnacle->save();
    }

    public function getAccessToken($control_app='ctac'){
        $url_aux = config('app.advans_apps_url.'.$control_app);
        //TODO Fix this. Put right cert
        $http = new \GuzzleHttp\Client(['verify' => false]);
        $response = $http->post($url_aux.'/oauth/token', [
            'form_params' => config('app.advans_apps_security.'.$control_app),
        ]);

        $vartemp = json_decode((string) $response->getBody(), true);
        return $vartemp;
    }


    public function getAppService($access_token,$app_service,$arrayparams,$control_app='ctac'){
        //TODO Fix this. Put right cert
        $http = new \GuzzleHttp\Client(['verify' => false]);

        $logued_user = Auth::user();
        if($logued_user){
            $arrayparams['user_name'] = $logued_user->name;
        }
        $query = http_build_query($arrayparams);

        $url_aux = config('app.advans_apps_url.'.$control_app);
        $array_send = [
                       'headers' => [
                                    'Authorization' => 'Bearer '.$access_token,
                                    ]
                      ];
        $response = $http->get($url_aux.'/api/'.$app_service.'?'.$query, $array_send);

        return json_decode((string) $response->getBody(), true);
    }

    public function validateRfc($rfc){
        
    }

    function rand_chars($c, $l, $u = FALSE) { 
      if (!$u) for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c{$x}, $i++); 
      else for ($i = 0, $z = strlen($c)-1, $s = $c{rand(0,$z)}, $i = 1; $i != $l; $x = rand(0,$z), $s .= $c{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s)); 
      return $s; 
    } 

    public function getCpData(Request $request)
    {
        $alldata = $request->all();
        $result_response = [];
        $states_key = config('app.states_key');
        $testval = '';
        $munics = [];
        $query = Cpmex::select();
        if(array_key_exists('cp',$alldata)){
            if($alldata['cp']!=''){
                $d_codigo = "%".$alldata['cp']."%";
                $query->where('d_codigo', 'like', $d_codigo);
            }
        }
        if(array_key_exists('dommunicserv',$alldata)){
            if($alldata['dommunicserv']!=''){
                $query->where('c_mnpio', '=', $alldata['dommunicserv']);
            }
        }
        if(array_key_exists('domestadoserv',$alldata)){
            if($alldata['domestadoserv']!=''){
                $munics = Munic::where('m_state',strtoupper($alldata['domestadoserv']))->get();
                $query->where('c_estado', '=', $states_key[$alldata['domestadoserv']]);
            }
        }
        $result_response = $query->get();
        
        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
            'tabledata' => $result_response,
            'munics' => $munics,
            'alldata' => $alldata
        );
        return \Response::json($response);
    }

    public function auxGigRfcCalc($paqid)
    {
        $rfc = 0;
        $gig = 0;
        $return_rfc = 0;
        $return_gig = 0;
        $asig_distrib_rfc = 0;
        $asig_distrib_gig = 0;
        $distrib = false;

        if($paqid!=false){
            $paq_obj = Package::find($paqid);
            $rfc = $paq_obj->paq_rfc;
            $gig = $paq_obj->paq_gig;
            $distrib = Auth::user()->distributor ? Auth::user()->distributor : false;
            if($distrib!=false){
                $distribassignations = Packageassignation::where('asigpaq_distrib_id','=',$distrib->id)->where('asigpaq_f_caduc','>=',date("Y-m-d"))->get();
                foreach ($distribassignations as $distribassignation) {
                    $asig_distrib_rfc += $distribassignation->asigpaq_rfc;
                    $asig_distrib_gig += $distribassignation->asigpaq_gig;
                }
                $rfc_assigs = ($distrib->distrib_limitrfc + ($asig_distrib_rfc));
                $gig_assigs = ($distrib->distrib_limitgig + ($asig_distrib_gig));
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
            }else{
                $return_gig = $gig;
                $return_rfc = $rfc;
            }

        }else{
            $return_gig = $gig;
            $return_rfc = $rfc;
        }
        $response = array(
            'gig' => $return_gig ,
            'rfc' => $return_rfc,
        );
        return $response;
    }

    public function controllerUserCanAccess($user,$distrib_id){
        if($user->usrc_admin || $user->usrc_super){
            return true;
        }else{
            if($user->usrc_distrib_id==$distrib_id){
                return true;
            }
        }
        return false;
    }


    public function getArt(Request $request)
    {
        $alldata = $request->all();
        
        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
            'tabledata' => Art69::all()
        );
        return \Response::json($response);
    }


    public function importart(Request $request)
    {
        $alldata = $request->all();
        return redirect()->route('arts.index');
    }

}
