<?php

namespace App\Http\Controllers;

use App\Account;
use App\Client;
use App\Distributor;
use Illuminate\Http\Request;

class AccountController extends Controller
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
        $accounts = Account::all();
        return view('appviews.accountshow',['accounts'=>$accounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $distributors = Distributor::all();
        return view('appviews.accountcreate',['clients'=>$clients,'distributors'=>$distributors]);
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
        //$alldata['cta_fecha'] .= ' '. date('H:i:s');
        /*echo "<pre>";
        print_r($alldata);die();
        echo "</pre>";*/
        $cta = new Account($alldata);
        $cta->save();
        \Session::flash('message','Se ha creado la cuenta: '.$alldata['cta_num']);
        return redirect()->route('account.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        if (isset($account)){
            \Session::flash('message','Se ha eliminado la cuenta: '.$account->cta_num);
            $account->delete();

        }
        return redirect()->route('account.index');
    }
}
