<?php

namespace App\Http\Middleware;

use Closure;

class ChangeCon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        //TODO Uncomment for multiple BD Con
        /*$alldata = $request->all();
        $midred = $request->session()->exists('midred');
        if(!$midred){
            if(array_key_exists('login_rfc',$alldata)){
                $dbvalue = config('database.connections');
                if(array_key_exists($alldata['login_rfc'],$dbvalue)){
                    \Session::put('selected_database',$alldata['login_rfc']);
                    \Config::set('database.default', $alldata['login_rfc']);
                    $request->session()->pull('loginrfcerr');
                    //$request->session()->pull('login_rfc');
                }else{
                    $request->session()->flash('midred', '1');
                    $request->session()->put('loginrfcerr', 'RFC Inválido'); 
                    $request->session()->put('login_rfc', $alldata['login_rfc']);                  
                    return redirect('/');
                }
             }
         }*/

        return $next($request);
    }
}
