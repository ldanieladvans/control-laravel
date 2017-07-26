<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packageassignation;
use App\Package;
use App\Distributor;
use Illuminate\Support\Facades\Auth;

class PackageassignationController extends Controller
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
        if($logued_user->usrc_admin || $logued_user->can('see.assigs')){
            if($logued_user->usrc_admin || $logued_user->usrc_super){
                $asigpaqs = Packageassignation::all();
            }else{
                $asigpaqs = Packageassignation::where('asigpaq_distrib_id',$logued_user->usrc_distrib_id)->get();
            }
            return view('appviews.packassigshow',['asigpaqs'=>$asigpaqs]);
        }else{
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('create.assigs')){
            $packages = Package::all();
            $distributors = Distributor::all();
            return view('appviews.packassigcreate',['packages'=>$packages,'distributors'=>$distributors]);
        }else{
            return view('errors.403');
        } 
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
        if($logued_user->usrc_admin || $logued_user->can('create.assigs')){
            $alldata = $request->all();
            $asigpaq = new Packageassignation($alldata);
            $asigpaq->asigpaq_f_vent = date('Y-m-d');
            $asigpaq->asigpaq_f_act = date('Y-m-d');
            $asigpaq->save();
            $fmessage = 'Se ha realizado un asignación al distribuidor: '.($asigpaq->asigpaq_distrib_id ? $asigpaq->distributor->distrib_nom : '');
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'store', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('asigpaq.index');
        }else{
            return view('errors.403');
        }
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
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.assigs')){
            $asigpaq = Packageassignation::findOrFail($id);
            $packages = Package::all();
            $distributors = Distributor::all();
            $return_rfc = 0;
            $return_gig = 0;
            $compute_rfc = 0;
            $compute_gig = 0;
            if(!$this->controllerUserCanAccess(Auth::user(),$asigpaq->asigpaq_distrib_id)){
                return view('errors.403');
            }
            $self_rfc = $asigpaq->asigpaq_rfc ? $asigpaq->asigpaq_rfc : 0;
            $self_gig = $asigpaq->asigpaq_gig ? $asigpaq->asigpaq_gig : 0;
            if(isset($asigpaq->asigpaq_paq_id)){
                $result = $this->auxGigRfcCalc($asigpaq->asigpaq_paq_id);
                $compute_rfc = $result['rfc'];
                $compute_gig = $result['gig'];
            }
            $return_rfc = $compute_rfc > $self_rfc ? $compute_rfc : $self_rfc;
            $return_gig = $compute_gig > $self_gig ? $compute_gig : $self_gig;      
            return view('appviews.packassigedit',['packages'=>$packages,'distributors'=>$distributors,'asigpaq'=>$asigpaq,'rfc'=>$return_rfc,'gig'=>$return_gig]);
        }else{
            return view('errors.403');
        }
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
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('edit.assigs')){
            $alldata = $request->all();
            $asigpaq = Packageassignation::findOrFail($id);
            if(!$this->controllerUserCanAccess(Auth::user(),$asigpaq->asigpaq_distrib_id)){
                return view('errors.403');
            }
            $asigpaq->asigpaq_rfc = $alldata['asigpaq_rfc'];
            $asigpaq->asigpaq_gig = $alldata['asigpaq_gig'];
            $asigpaq->asigpaq_f_fin = $alldata['asigpaq_f_fin'];
            $asigpaq->asigpaq_f_caduc = $alldata['asigpaq_f_caduc'];
            if(array_key_exists('asigpaq_distrib_id',$alldata) && isset($alldata['asigpaq_distrib_id'])){
                if($alldata['asigpaq_distrib_id']!=''){
                    $asigpaq->asigpaq_distrib_id = $alldata['asigpaq_distrib_id'];
                }
            }
            if(array_key_exists('asigpaq_paq_id',$alldata) && isset($alldata['asigpaq_paq_id'])){
                if($alldata['asigpaq_paq_id']!='null'){
                    $asigpaq->asigpaq_paq_id = $alldata['asigpaq_paq_id'];
                }
            }
            $asigpaq->save();
            $fmessage = 'Se ha actualizado la asignación con id: '.$asigpaq->id;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('asigpaq.index');
        }else{
            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin || $logued_user->can('delete.assigs')){
            if (isset($id)){
                $asigpaq = Packageassignation::findOrFail($id);
                if(!$this->controllerUserCanAccess(Auth::user(),$asigpaq->asigpaq_distrib_id)){
                    return view('errors.403');
                }
                $fmessage = 'Se ha eliminado la asignación: '.($asigpaq->asigpaq_rfc.' - '.$asigpaq->asigpaq_gig.' - '.($asigpaq->asigpaq_distrib_id ? $asigpaq->distributor->distrib_nom : '').' - '.$id);
                \Session::flash('message',$fmessage);
                $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                $asigpaq->delete();

            }
            return redirect()->route('asigpaq.index');
        }else{
            return view('errors.403');
        }
    }

    public function getgigrfcbypack(Request $request)
    {
        $alldata = $request->all();
        $return_rfc = 0;
        $return_gig = 0;

        if(array_key_exists('paqid',$alldata) && isset($alldata['paqid'])){
            $paqid = $alldata['paqid'];
            $result = $this->auxGigRfcCalc($paqid);
            $return_rfc = $result['rfc'];
            $return_gig = $result['gig'];
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'gig' => $return_gig ,
            'rfc' => $return_rfc,
        );
        return \Response::json($response);
    }
}
