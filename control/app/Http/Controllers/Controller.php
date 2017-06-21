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
    	/*['bitc_usrc_id'=>$user->id,'bitc_fecha'=>date("Y-m-d H:i:s"),'bitc_tipo_op'=>$fname,'bitc_ip'=>$request->ip(),'bitc_naveg'=>$browser->getName().' '.$browser->getVersion(),'bitc_modulo'=>$split_var[1],'bitc_result'=>'TODO','bitc_msj'=>$fmessage,'bitc_dat'=>json_encode($request->all())]*/
    	$binnacle->bitc_usrc_id = $user->id;
    	$binnacle->bitc_fecha = date("Y-m-d H:i:s");
    	$binnacle->bitc_tipo_op = $fname;
    	$binnacle->bitc_ip = $request->ip();
    	$binnacle->bitc_naveg = $browser->getName().' '.$browser->getVersion();
    	$binnacle->bitc_modulo = $split_var[1];
    	$binnacle->bitc_result = 'TODO';
    	$binnacle->bitc_msj = $fmessage;
    	$binnacle->bitc_dat = json_encode($request->all());
    	$binnacle->save();
    }
}
