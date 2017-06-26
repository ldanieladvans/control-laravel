<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packageassignation;
use App\Package;
use App\Distributor;

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


        return view('appviews.packassigedit',['packages'=>$packages,'distributors'=>$distributors,'asigpaq'=>$asigpaq]);
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
        $asigpaq->asigpaq_f_vent = $alldata['asigpaq_f_vent'];
        $asigpaq->asigpaq_f_act = $alldata['asigpaq_f_act'];
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
}
