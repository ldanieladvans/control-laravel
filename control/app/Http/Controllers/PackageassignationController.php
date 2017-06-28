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
        $asigpaqs = Packageassignation::all();
        return view('appviews.packassigshow',['asigpaqs'=>$asigpaqs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        $distributors = Distributor::all();
        return view('appviews.packassigcreate',['packages'=>$packages,'distributors'=>$distributors]); 
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
        $asigpaq = new Packageassignation($alldata);
        $asigpaq->asigpaq_f_vent = date('Y-m-d');
        $asigpaq->asigpaq_f_act = date('Y-m-d');
        $asigpaq->save();

        $fmessage = 'Se ha asignado un paquete a un distribuidor ocn id: '.$asigpaq->id;
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('asigpaq.index');
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
        $asigpaq = Packageassignation::findOrFail($id);
        $packages = Package::all();
        $distributors = Distributor::all();

        $return_rfc = 0;
        $return_gig = 0;

        $compute_rfc = 0;
        $compute_gig = 0;

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
        $alldata = $request->all();
        $asigpaq = Packageassignation::findOrFail($id);
        $asigpaq->asigpaq_rfc = $alldata['asigpaq_rfc'];
        $asigpaq->asigpaq_gig = $alldata['asigpaq_gig'];
        /*$asigpaq->asigpaq_f_vent = $alldata['asigpaq_f_vent'];
        $asigpaq->asigpaq_f_act = $alldata['asigpaq_f_act'];*/
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

        $fmessage = 'Se ha actualizado un paquete a un distribuidor ocn id: '.$asigpaq->id;
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);
        return redirect()->route('asigpaq.index');
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
            $asigpaq = Packageassignation::findOrFail($id);
            $fmessage = 'Se ha eliminado la asignacion de distribuidor-paquete: '.$asigpaq->asigpaq_rfc.' '.$asigpaq->asigpaq_gig.' '.$asigpaq->asigpaq_distrib_id.' '.$asigpaq->asigpaq_paq_id;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'destroy',$fmessage);
            $asigpaq->delete();

        }
        return redirect()->route('asigpaq.index');
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


    public function auxGigRfcCalc($paqid)
    {

        $rfc = 0;
        $gig = 0;

        $return_rfc = 0;
        $return_gig = 0;

        $asig_distrib_rfc = 0;
        $asig_distrib_gig = 0;

        $distrib = false;

        /*echo "<pre>";
        print_r($rfc);die();
        echo "</pre>";*/

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
}
