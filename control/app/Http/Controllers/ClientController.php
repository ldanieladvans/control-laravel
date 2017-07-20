<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Reference;
use App\Domicile;
use Illuminate\Support\Facades\Validator;
use App\Munic;
use App\Cpmex;
use App\Country;
use App\Distributor;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
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
            $clients = Client::all();
        }else{
            $clients = Client::where('cliente_distrib_id',$logued_user->usrc_distrib_id)->orWhere('cliente_distrib_id', null)->get();
        }
        return view('appviews.clientshow',['clients'=>$clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $references = Reference::all();
        $domiciles = Domicile::all();
        $countries = Country::all();
        $distributors = Distributor::all();
        return view('appviews.clientcreate',['references'=>$references,'domiciles'=>$domiciles,'countries'=>$countries,'distributors'=>$distributors]);
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
        $parseCert = false;
        if(array_key_exists('client_cert',$alldata)){
            $cert     = request()->file('client_cert');
            $path = $request->file('client_cert')->storeAs('public', $alldata['cliente_rfc'].'.'.$cert->getClientOriginalName());
            $parseCert = openssl_x509_parse(file_get_contents(storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$alldata['cliente_rfc'].'.'.$cert->getClientOriginalName()));
            if ($parseCert == FALSE) {
                /* Convert .cer to .pem, cURL uses .pem */
                $certificateCApemContent = '-----BEGIN CERTIFICATE-----' . PHP_EOL
                        . chunk_split(base64_encode($cert), 64, PHP_EOL)
                        . '-----END CERTIFICATE-----' . PHP_EOL;
                $certificateCApem = $certificateCApemContent  . '.pem';
                $parseCert = openssl_x509_parse($certificateCApemContent);
            }
            $alldata['cert_f_ini'] = $parseCert['validFrom_time_t'];
            $alldata['cert_f_fin'] = $parseCert['validTo_time_t'];  
        }

        $dom_vals = array();
        $refer_vals = array();
        $client_vals = array();
        $domicile_id = array_key_exists('cliente_dom_id',$alldata) ? $alldata['cliente_dom_id'] : false;
        $refer_id = array_key_exists('cliente_refer_id',$alldata) ? $alldata['cliente_refer_id'] : false;
        if (array_key_exists('checkdom',$alldata)){           
            if (array_key_exists('dom_calle',$alldata) && isset($alldata['dom_calle'])){
                $dom_vals['dom_calle'] = $alldata['dom_calle'];
                if (array_key_exists('dom_col',$alldata)){
                $dom_vals['dom_col'] = $alldata['dom_col'];
                }
                if (array_key_exists('dom_ciudad',$alldata)){
                    $dom_vals['dom_ciudad'] = $alldata['dom_ciudad'];
                }
                if (array_key_exists('dom_munic',$alldata)){
                    $dom_vals['dom_munic'] = $alldata['dom_munic'];
                }
                if (array_key_exists('dom_estado',$alldata)){
                    $dom_vals['dom_estado'] = $alldata['dom_estado'];
                }
                if (array_key_exists('dom_pais',$alldata)){
                    $dom_vals['dom_pais'] = $alldata['dom_pais'];
                }
                if (array_key_exists('dom_cp',$alldata)){
                    $dom_vals['dom_cp'] = $alldata['dom_cp'];
                }
                if (array_key_exists('dom_numext',$alldata)){
                    $dom_vals['dom_numext'] = $alldata['dom_numext'];
                }
                if (array_key_exists('dom_numint',$alldata)){
                    $dom_vals['dom_numint'] = $alldata['dom_numint'];
                }
                if (array_key_exists('dom_country',$alldata)){
                    if($alldata['dom_country']!=''){
                        $countries = Country::where('c_char_code',$alldata['dom_country'])->get();
                        $dom_vals['dom_pais'] = $countries[0]['c_name_es'];
                    }
                    
                }
                $domicile = new Domicile($dom_vals);
                $domicile->save();
                $domicile_id = $domicile->id;
            }
        }

        if(array_key_exists('checkrefer',$alldata) && isset($alldata['refer_nom'])){
            if (array_key_exists('refer_nom',$alldata)){
                $refer_vals['refer_nom'] = $alldata['refer_nom'];
                if (array_key_exists('refer_rfc',$alldata)){
                $refer_vals['refer_rfc'] = $alldata['refer_rfc'];
                }
                $refer = new Reference($refer_vals);
                $refer->save();
                $refer_id = $refer->id;
            }
        }

        $client_vals['cliente_nom'] = $alldata['cliente_nom'];
        $client_vals['cliente_correo'] = $alldata['cliente_correo'];
        $client_vals['cliente_tel'] = $alldata['cliente_tel'];
        $rules = ['cliente_rfc' => 'required|rfc'];
        $messages = ['rfc' => 'RFC inválido'];
        $validator = Validator::make($alldata, $rules, $messages)->validate();
        $client_vals['cliente_rfc'] = $alldata['cliente_rfc'];
        $client_vals['cliente_nac'] = $alldata['cliente_nac'];
        $client_vals['cliente_tipo'] = $alldata['cliente_tipo'];
        if(array_key_exists('cliente_distrib_id',$alldata)){
            if ($alldata['cliente_distrib_id']!=''){
                $client_vals['cliente_distrib_id'] = $alldata['cliente_distrib_id'];
            }
        }
        $client = new Client($client_vals);
        if ($domicile_id != "null"){
            $client->cliente_dom_id = $domicile_id;
        }
        if ($refer_id != "null"){
            $client->cliente_refer_id = $refer_id;
        }
        $client->save();
        $fmessage = 'Se ha creado el cliente: '.$alldata['cliente_nom'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('client.index');
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
    public function edit(Client $client)
    {
        $references = Reference::all();
        $domiciles = Domicile::all();
        $countries = Country::all();
        $distributors = Distributor::all();
        if(!$this->controllerUserCanAccess(Auth::user(),$client->cliente_distrib_id)){
            return view('errors.403');
        }
        return view('appviews.clientedit',['client'=>$client,'references'=>$references,'domiciles'=>$domiciles,'countries'=>$countries,'distributors'=>$distributors]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $alldata = $request->all();
        $dom_vals = array();
        $refer_vals = array();
        $domicile_id = array_key_exists('cliente_dom_id',$alldata) ? $alldata['cliente_dom_id'] : false;
        $refer_id = array_key_exists('cliente_refer_id',$alldata) ? $alldata['cliente_refer_id'] : false;
        if(!$this->controllerUserCanAccess(Auth::user(),$client->cliente_distrib_id)){
            return view('errors.403');
        }
        if (array_key_exists('checkdom',$alldata)){           
            if (array_key_exists('dom_calle',$alldata) && isset($alldata['dom_calle'])){
                $dom_vals['dom_calle'] = $alldata['dom_calle'];
                if (array_key_exists('dom_col',$alldata)){
                $dom_vals['dom_col'] = $alldata['dom_col'];
                }
                if (array_key_exists('dom_ciudad',$alldata)){
                    $dom_vals['dom_ciudad'] = $alldata['dom_ciudad'];
                }
                if (array_key_exists('dom_munic',$alldata)){
                    $dom_vals['dom_munic'] = $alldata['dom_munic'];
                }
                if (array_key_exists('dom_estado',$alldata)){
                    $dom_vals['dom_estado'] = $alldata['dom_estado'];
                }
                if (array_key_exists('dom_pais',$alldata)){
                    $dom_vals['dom_pais'] = $alldata['dom_pais'];
                }
                if (array_key_exists('dom_cp',$alldata)){
                    $dom_vals['dom_cp'] = $alldata['dom_cp'];
                }
                if (array_key_exists('dom_numext',$alldata)){
                    $dom_vals['dom_numext'] = $alldata['dom_numext'];
                }
                if (array_key_exists('dom_numint',$alldata)){
                    $dom_vals['dom_numint'] = $alldata['dom_numint'];
                }
                if (array_key_exists('dom_country',$alldata)){
                    if($alldata['dom_country']!=''){
                        $countries = Country::where('c_char_code',$alldata['dom_country'])->get();
                        $dom_vals['dom_pais'] = $countries[0]['c_name_es'];
                    }
                    
                }
                $domicile = new Domicile($dom_vals);
                $domicile->save();
                $domicile_id = $domicile->id;
            }
        }

        if (array_key_exists('checkrefer',$alldata) && isset($alldata['refer_nom'])){
            if (array_key_exists('refer_nom',$alldata)){
                $refer_vals['refer_nom'] = $alldata['refer_nom'];
                if (array_key_exists('refer_rfc',$alldata)){
                $refer_vals['refer_rfc'] = $alldata['refer_rfc'];
                }
                $refer = new Reference($refer_vals);
                $refer->save();
                $refer_id = $refer->id;
            }
        }

        $client->cliente_nom = $alldata['cliente_nom'];
        $client->cliente_correo = $alldata['cliente_correo'];
        $client->cliente_tel = $alldata['cliente_tel'];
        $rules = ['cliente_rfc' => 'required|rfc'];
        $messages = ['rfc' => 'RFC inválido'];
        $validator = Validator::make($alldata, $rules, $messages)->validate();
        $client->cliente_rfc = $alldata['cliente_rfc'];
        $client->cliente_nac = $alldata['cliente_nac'];
        $client->cliente_tipo = $alldata['cliente_tipo'];
        if(array_key_exists('cliente_distrib_id',$alldata)){
            if ($alldata['cliente_distrib_id']!=''){
                $client->cliente_distrib_id = $alldata['cliente_distrib_id'];
            }
        }
        if ($domicile_id != "null"){
            $client->cliente_dom_id = $domicile_id;
        }
        if ($refer_id != "null"){
            $client->cliente_refer_id = $refer_id;
        }
        $client->save();
        $fmessage = 'Se ha actualizado el cliente: '.$alldata['cliente_nom'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client,Request $request)
    {
        if(!$this->controllerUserCanAccess(Auth::user(),$client->cliente_distrib_id)){
            return view('errors.403');
        }
        if (isset($client)){
            $fmessage = 'Se ha eliminado el cliente: '.$client->cliente_nom;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'destroy',$fmessage);
            $client->delete();
        }
        return redirect()->route('client.index');
    }

    /**
     * Search for a client by name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clientsearch(Request $request)
    {
        $fname = (string)$request->csearch;
        $clients = Client::where('cliente_nom', 'like', '%'.$fname.'%')->get();
        return view('appviews.clientshow',['clients'=>$clients]);
    }
}
