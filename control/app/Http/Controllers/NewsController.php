<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
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
        if($logued_user->usrc_admin || $logued_user->can('see.news')){
            $news = News::all();
            return view('appviews.newshow',['news'=>$news]);
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
        if($logued_user->usrc_admin || $logued_user->can('create.news')){
            return view('appviews.newscreate');
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
        if($logued_user->usrc_admin || $logued_user->can('create.news')){
            $alldata = $request->all();
            $news = new News($alldata);
            $news->save();
            $fmessage = 'Se ha creado la noticia: '.$alldata['tittle'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'store', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('news.index');
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
        if($logued_user->usrc_admin || $logued_user->can('edit.news')){
            $news = News::findOrFail($id);
            return view('appviews.newsedit',['news'=>$news]);
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
        if($logued_user->usrc_admin || $logued_user->can('edit.news')){
            $alldata = $request->all();
            $news = News::findOrFail($id);
            $news->tittle = $alldata['tittle'];
            $news->pdate = $alldata['pdate'];
            $news->description = $alldata['description'];
            $news->nactivo = $alldata['nactivo'];
            $news->save();
            $fmessage = 'Se ha actualizado la noticia: '.$alldata['tittle'];
            \Session::flash('message',$fmessage);
            $this->registeredBinnacle($request->all(), 'update', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
            return redirect()->route('news.index');
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
        if($logued_user->usrc_admin || $logued_user->can('delete.news')){
            if (isset($id)){
                $news = News::findOrFail($id);
                $fmessage = 'Se ha eliminado la noticia: '.$news->tittle;
                \Session::flash('message',$fmessage);
                $this->registeredBinnacle($request->all(), 'destroy', $fmessage, $logued_user ? $logued_user->id : '', $logued_user ? $logued_user->name : '');
                $news->delete();

            }
            return redirect()->route('news.index');
        }else{
            return view('errors.403');
        }
    }
}
