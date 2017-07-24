<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Distributor;
use App\Domicile;
use App\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
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
            $distributors = Distributor::all();
        }else{
            $distributors = [Distributor::findOrFail($logued_user->usrc_distrib_id)];
        }
        return view('appviews.distributorshow',['distributors'=>$distributors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $domiciles = Domicile::all();
        $countries = Country::all();
        return view('appviews.distributorcreate',['domiciles'=>$domiciles,'countries'=>$countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logued_user = Auth::user();
        $alldata = $request->all();
        $dom_vals = array();
        $distributor_vals = array();
        $domicile_id = array_key_exists('distrib_dom_id',$alldata) ? $alldata['distrib_dom_id'] : false;
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

        $distributor_vals['distrib_nom'] = $alldata['distrib_nom'];
        $rules = ['distrib_rfc' => 'required|rfc'];
        $messages = ['rfc' => 'RFC inválido'];
        $validator = Validator::make($alldata, $rules, $messages)->validate();
        $distributor_vals['distrib_rfc'] = $alldata['distrib_rfc'];
        $distributor_vals['distrib_limitgig'] = $alldata['distrib_limitgig'];
        $distributor_vals['distrib_limitrfc'] = $alldata['distrib_limitrfc'];
        $distributor_vals['distrib_tel'] = $alldata['distrib_tel'];
        $distributor_vals['distrib_correo'] = $alldata['distrib_correo'];
        $distributor_vals['distrib_nac'] = $alldata['distrib_nac'];
        $distributor_vals['distrib_sup'] = $alldata['distrib_sup'];
        $distributor = new Distributor($distributor_vals);

        if ($domicile_id != "null"){
            $distributor->distrib_dom_id = $domicile_id;
        }

        $distributor->save();
        $fmessage = 'Se ha creado el distribuidor: '.$alldata['distrib_nom'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request->all(), 'store', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
        return redirect()->route('distributor.index');
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
    public function edit(Distributor $distributor)
    {
        $domiciles = Domicile::all();
        $countries = Country::all();
        if(!$this->controllerUserCanAccess(Auth::user(),$distributor->id)){
            return view('errors.403');
        }
        return view('appviews.distributoredit',['distributor'=>$distributor,'domiciles'=>$domiciles,'countries'=>$countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distributor $distributor)
    {
        $logued_user = Auth::user();
        $alldata = $request->all();
        $dom_vals = array();
        $distributor_vals = array();
        $domicile_id = array_key_exists('distrib_dom_id',$alldata) ? $alldata['distrib_dom_id'] : false;
        if(!$this->controllerUserCanAccess(Auth::user(),$distributor->id)){
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

        $distributor->distrib_nom = $alldata['distrib_nom'];
        $rules = ['distrib_rfc' => 'required|rfc'];
        $messages = ['rfc' => 'RFC inválido'];
        $validator = Validator::make($alldata, $rules, $messages)->validate();
        $distributor->distrib_rfc = $alldata['distrib_rfc'];
        $distributor->distrib_limitgig = $alldata['distrib_limitgig'];
        $distributor->distrib_limitrfc = $alldata['distrib_limitrfc'];
        $distributor->distrib_tel = $alldata['distrib_tel'];
        $distributor->distrib_correo = $alldata['distrib_correo'];
        $distributor->distrib_nac = $alldata['distrib_nac'];
        $distributor->distrib_sup = $alldata['distrib_sup'];

        if ($domicile_id != "null"){
            $distributor->distrib_dom_id = $domicile_id;
        }

        $distributor->save();

        $fmessage = 'Se ha actualizado el distribuidor: '.$alldata['distrib_nom'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
        return redirect()->route('distributor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distributor $distributor, Request $request)
    {
        $logued_user = Auth::user();
        if(!$this->controllerUserCanAccess(Auth::user(),$distributor->id)){
            return view('errors.403');
        }
        if (isset($distributor)){
            $fmessage = 'Se ha eliminado el distribuidor: '.$distributor->distrib_nom;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            $distributor->delete();
        }
        return redirect()->route('distributor.index');
    }
}
