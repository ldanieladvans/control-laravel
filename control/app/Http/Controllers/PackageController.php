<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;

class PackageController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('appviews.packageshow',['packages'=>$packages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appviews.packagecreate');
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
        $pack = new Package($alldata);
        $pack->save();
        $fmessage = 'Se ha creado el paquete: '.$alldata['paq_nom'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('package.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        $packages = Package::all();
        return view('appviews.packageshow',['packages'=>$packages]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //$package = Package::findOrFail($id);
        return view('appviews.packageedit',['package'=>$package]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //$package = Package::findOrFail($id);
        $package->paq_nom = $request->paq_nom;
        $package->paq_gig = $request->paq_gig;
        $package->paq_rfc = $request->paq_rfc;
        $package->save();
        $fmessage = 'Se ha actualizado el paquete: '.$request->paq_nom;
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);
        return redirect()->route('package.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package,Request $request)
    {
        if (isset($id)){
            //$package = Package::findOrFail($id);
            $fmessage = 'Se ha eliminado el paquete: '.$package->paq_nom;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request,'destroy',$fmessage);
            $package->delete();

        }
        return redirect()->route('package.index');
    }
}
