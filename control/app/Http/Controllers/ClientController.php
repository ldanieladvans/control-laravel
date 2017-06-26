<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Reference;
use App\Domicile;

class ClientController extends Controller
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
        $clients = Client::all();
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
        return view('appviews.clientcreate',['references'=>$references,'domiciles'=>$domiciles]);
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

        $client_vals['cliente_nom'] = $alldata['cliente_nom'];
        $client_vals['cliente_correo'] = $alldata['cliente_correo'];
        $client_vals['cliente_tel'] = $alldata['cliente_tel'];
        $client_vals['cliente_rfc'] = $alldata['cliente_rfc'];
        $client_vals['cliente_nac'] = $alldata['cliente_nac'];
        $client_vals['cliente_tipo'] = $alldata['cliente_tipo'];
        $client_vals['cliente_sexo'] = $alldata['gender'];

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
        return view('appviews.clientedit',['client'=>$client,'references'=>$references,'domiciles'=>$domiciles]);
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
        $client->cliente_rfc = $alldata['cliente_rfc'];
        $client->cliente_nac = $alldata['cliente_nac'];
        $client->cliente_tipo = $alldata['cliente_tipo'];
        $client->cliente_sexo = $alldata['gender'];

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
