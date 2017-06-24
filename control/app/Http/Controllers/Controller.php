<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Binnacle;
use Illuminate\Http\Request;
use Sinergi\BrowserDetector\Browser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function registeredBinnacle(Request $request, $fname='', $fmessage=''){
    	$user = \Auth::user();
    	$browser = new Browser();
    	$split_var = explode('\Controllers',get_class($this));
    	$binnacle = new Binnacle();
    	$binnacle->bitc_usrc_id = $user->id;
    	$binnacle->bitc_fecha = date("Y-m-d H:i:s");
    	$binnacle->bitc_tipo_op = $fname;
    	/*$binnacle->bitc_ip = $request->ip();
    	$binnacle->bitc_naveg = $browser->getName().' '.$browser->getVersion();*/
        $binnacle->bitc_ip = $binnacle->getrealip();
        $browser_arr = $binnacle->getBrowser();
        $binnacle->bitc_naveg = $browser_arr['name'].' '.$browser_arr['version'];
    	$binnacle->bitc_modulo = $split_var[1];
    	$binnacle->bitc_result = 'TODO';
    	$binnacle->bitc_msj = $fmessage;
    	$binnacle->bitc_dat = json_encode($request->all());
    	$binnacle->save();
    }

    public function getAccessToken($control_app='ctac'){
        $url_aux = config('app.advans_apps_url.'.$control_app);
        $http = new \GuzzleHttp\Client();
        $response = $http->post($url_aux.'/oauth/token', [
            'form_params' => config('app.advans_apps_security.'.$control_app),
        ]);

        $vartemp = json_decode((string) $response->getBody(), true);
        return $vartemp;
    }


    public function getAppService($access_token,$app_service,$arrayparams,$control_app='ctac'){
        $http = new \GuzzleHttp\Client();

        /*$query = http_build_query([
            'rfc_nombrebd' => 'nuevaint1',
        ]);*/
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
}
