<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\Appaccount;
use App\Account;
use Illuminate\Support\Facades\Log;

class ApiserviceController extends Controller
{

    public function __construct()
    {
        //This allow only to api users
        $this->middleware('role:api');
    }

    public function getUsersRolesPermsByBd(Request $request)
    {

        $client_rfc = '';
        $apps = array();
        $packs = array();
        $appcta = false;

        $arrayreturn = array();
        $arrayroles = array();

        $alldata = $request->all();

        if(array_key_exists('rfc',$alldata) && isset($alldata['rfc'])){
            $rfc_accid = explode('_', $alldata['rfc']);
            $roles = Role::all();
            foreach ($roles as $role) {
                $perm_array = array();
                $permissions = $role->permissions()->get();
                foreach ($permissions as $permission) {
                    array_push($perm_array, [$permission->slug,$permission->name]);
                }
                $arrayreturn[$role->slug.'-'.$role->name] = $perm_array;
                $arrayroles[$role->slug] = $role->name;
            }
            
        }


        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'rolesperms' => json_encode($arrayreturn),
            'roles'=> json_encode($arrayroles)
        );
        return \Response::json($response);
    }

    public function getAccState(Request $request)
    {

        $client_rfc = '';
        $apps = array();
        $packs = array();
        $appcta = false;

        $arrayparams = array();

        $alldata = $request->all();

        $acc_state = 'None';

        if(array_key_exists('rfc',$alldata) && isset($alldata['rfc'])){
            $appcta = Account::where('cta_num',$alldata['rfc'])->get();
            Log::info($appcta);
            if(count($appcta) > 0){
                $acc_state = $appcta[0]['cta_estado'];
            }
            
        }


        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'accstate' => $acc_state
        );
        return \Response::json($response);
    }
}
