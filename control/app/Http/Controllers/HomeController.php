<?php

namespace App\Http\Controllers;
use App\Account;
use App\Client;
use App\Distributor;
use App\Package;
use App\Packageassignation;
use App\Appaccount;
use App\Apps;
use Illuminate\Http\Request;
use App\Http\Middleware\ChangeCon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Mail\ClientCreate;
use Illuminate\Support\Facades\Mail;
use ReverseRegex\Lexer;
use ReverseRegex\Random\SimpleRandom;
use ReverseRegex\Parser;
use ReverseRegex\Generator\Scope;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->usrc_super){
          $clients = Client::all();
          $distributors = Distributor::all();
          $packages = Package::all();
          $accounts = Account::all();
          $asigpaqs = Packageassignation::where('asigpaq_f_vent','>=',mktime(0, 0, 0, date("m")-1, date("d"),date("Y")))
                                      ->where('asigpaq_f_vent','<=',date("Y-m-d"))->get();
          $appctas = Appaccount::where('appcta_f_vent','>=',mktime(0, 0, 0, date("m")-1, date("d"),date("Y")))
                                      ->where('appcta_f_vent','<=',date("Y-m-d"))->get();
          $accounts_active = Account::where('cta_estado','=','Activa')->get();
        }else{
          $clients = Client::where('cliente_distrib_id',$logued_user->usrc_distrib_id)->get();
          $distributors = [Distributor::find($logued_user->usrc_distrib_id)];
          $packages = Package::all();
          $accounts = Account::where('cta_distrib_id',$logued_user->usrc_distrib_id)->get();
          $asigpaqs = Packageassignation::where('asigpaq_f_vent','>=',mktime(0, 0, 0, date("m")-1, date("d"),date("Y")))
                                      ->where('asigpaq_f_vent','<=',date("Y-m-d"))->where('asigpaq_distrib_id',$logued_user->usrc_distrib_id)->get();
          $appctas = Appaccount::where('appcta_f_vent','>=',mktime(0, 0, 0, date("m")-1, date("d"),date("Y")))
                                      ->where('appcta_f_vent','<=',date("Y-m-d"))->where('appcta_distrib_id',$logued_user->usrc_distrib_id)->get();
          $accounts_active = Account::where('cta_estado','=','Activa')->where('cta_distrib_id',$logued_user->usrc_distrib_id)->get();        
        }

        $apps = Apps::all();
        
        $asigpaqs_array = [];
        $asigpaqs_array_return = [];
        $appctas_array = [];
        $appctas_array_return = [];

        

        foreach ($asigpaqs as $asigpaq) {
            if(array_key_exists(((string)$asigpaq->asigpaq_f_vent),$asigpaqs_array)){
                $asigpaqs_array[((string)$asigpaq->asigpaq_f_vent)] = $asigpaqs_array[((string)$asigpaq->asigpaq_f_vent)] + 1;
            }else{
                $asigpaqs_array[((string)$asigpaq->asigpaq_f_vent)] = 1;
            }
        }

        foreach ($asigpaqs_array as $key => $value) {
            array_push($asigpaqs_array_return, [$key,$value]);
        }


        
        foreach ($appctas as $appcta) {
            if(array_key_exists(((string)$appcta->appcta_f_vent),$appctas_array)){
                $appctas_array[((string)$appcta->appcta_f_vent)] = $appctas_array[((string)$appcta->appcta_f_vent)] + 1;
            }else{
                $appctas_array[((string)$appcta->appcta_f_vent)] = 1;
            }
        }

        foreach ($appctas_array as $key => $value) {
            array_push($appctas_array_return, [$key,$value]);
        }


        

        $distributors_top = Distributor::where('distrib_activo', 1)
                                       ->orderBy('distrib_limitrfc', 'desc')
                                       ->take(3)
                                       ->get();

        return view('home',['accounts_active'=>$accounts_active,'accounts'=>$accounts,'packages'=>$packages,'clients'=>$clients,'distributors'=>$distributors,'asigpaqs'=>json_encode($asigpaqs_array_return),'appctas'=>json_encode($appctas_array_return),'distributors_top'=>$distributors_top,'apps'=>$apps]);
    }

    

    
}
