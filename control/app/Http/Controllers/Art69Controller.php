<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Art69;
use Illuminate\Support\Facades\Auth;

class Art69Controller extends Controller
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
        if($logued_user->usrc_admin){
            $arts = Art69::all();
            return view('appviews.art69show',['arts'=>$arts]);
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
        if($logued_user->usrc_admin){
            return view('appviews.art69create');
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
        if($logued_user->usrc_admin){
            $alldata = $request->all();
            $art = new Art69($alldata);
            $art->save();
            $fmessage = 'Se ha creado una nueva entrada al articulo 69: '.$alldata['rfc'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'store', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('arts.index');
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
        if($logued_user->usrc_admin){
            $art = Art69::findOrFail($id);
            return view('appviews.art69edit',['art'=>$art]);
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
        if($logued_user->usrc_admin){
            $alldata = $request->all();
            $art = Art69::findOrFail($id);
            $art->rfc = $alldata['rfc'];
            $art->contribuyente = $alldata['contribuyente'];
            $art->tipo = $alldata['tipo'];
            $art->oficio = $alldata['oficio'];
            $art->fecha_sat = array_key_exists('fecha_sat', $alldata) ? $alldata['fecha_sat'] : null;
            $art->fecha_dof = array_key_exists('fecha_dof', $alldata) ? $alldata['fecha_dof'] : null;
            $art->url_oficio = array_key_exists('url_oficio', $alldata) ? $alldata['url_oficio'] : null;
            $art->url_anexo = array_key_exists('url_anexo', $alldata) ? $alldata['url_anexo'] : null;
            $art->save();
            $fmessage = 'Se ha actualizado la entrada al artiulo 69: '.$art->rfc;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('arts.index');
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
    public function destroy(Request $request)
    {
        $logued_user = Auth::user();
        if($logued_user->usrc_admin){
            if (isset($id)){
                $art = Art69::findOrFail($id);
                $fmessage = 'Se ha eliminado la entrada al articulo 69:: '.$art->id;
                \Session::flash('message',$fmessage);
                $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                $art->delete();

            }elseif($request){
                if(array_key_exists('id', $request)){
                    $art = Art69::findOrFail($request['id']);
                    $fmessage = 'Se ha eliminado la entrada al articulo 69:: '.$art->id;
                    \Session::flash('message',$fmessage);
                    $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                    $art->delete();
                }
            }
            return redirect()->route('arts.index');
        }else{
            return view('errors.403');
        }
    }

    public function destroyAjax(Request $request){
        $logued_user = Auth::user();
        $alldata = $request->all();
        if(array_key_exists('id', $alldata)){
            $art = Art69::findOrFail($alldata['id']);
            $fmessage = 'Se ha eliminado la entrada al articulo 69:: '.$art->id;
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            $art->delete();
        }       
        $response = array(
            'status' => 'success',
            'msg' => 'Ok',
        );
        return \Response::json($response);
    }
}
