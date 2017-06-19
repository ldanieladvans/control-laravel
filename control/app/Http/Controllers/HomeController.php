<?php

namespace App\Http\Controllers;
use App\Account;
use App\Client;
use App\Distributor;
use App\Package;
use App\Packageassignation;
use App\Appaccount;
use Illuminate\Http\Request;
use App\Http\Middleware\ChangeCon;
use Illuminate\Support\Facades\DB;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        $distributors = Distributor::all();
        $packages = Package::all();
        $accounts = Account::all();
        $asigpaqs_array = [];
        $asigpaqs_array_return = [];
        $appctas_array = [];
        $appctas_array_return = [];
        
        $asigpaqs = Packageassignation::where('asigpaq_f_vent','>=',mktime(0, 0, 0, date("m")-1, date("d"),date("Y")))
                                      ->where('asigpaq_f_vent','<=',date("Y-m-d"))->get();
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


        $appctas = Appaccount::where('appcta_f_vent','>=',mktime(0, 0, 0, date("m")-1, date("d"),date("Y")))
                                      ->where('appcta_f_vent','<=',date("Y-m-d"))->get();
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


        $accounts_active = Account::where('cta_estado','=','Activa')->get();

        $distributors_top = Distributor::where('distrib_activo', 1)
                                       ->orderBy('distrib_limitrfc', 'desc')
                                       ->take(3)
                                       ->get();

        return view('home',['accounts_active'=>$accounts_active,'accounts'=>$accounts,'packages'=>$packages,'clients'=>$clients,'distributors'=>$distributors,'asigpaqs'=>json_encode($asigpaqs_array_return),'appctas'=>json_encode($appctas_array_return),'distributors_top'=>$distributors_top]);
    }

    
}
