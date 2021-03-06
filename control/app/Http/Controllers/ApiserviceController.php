<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\Appaccount;
use App\Account;
use App\News;
use App\Cimail;
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

    public function getNews(Request $request)
    {

        $news = News::where('nactivo',1)->get();

        $response = array(
            'status' => 'success',
            'msg' => 'success',
            'news' => json_encode($news)
        );
        return \Response::json($response);
    }

    public function get69response(Request $request)
    {

        //conformacion de consulta para control
        $alldata = null;
        $alldata = $request->all();
        $parameters = [];
        $query = 'select id, rfc, contribuyente, oficio, tipo, fecha_sat, fecha_dof, url_oficio, url_anexo from `69` where ';


        if($alldata['by_rfc'] == 1)
        {
            if (array_key_exists('rfc_value',$alldata) && isset($alldata['rfc_value']))
            {
                $query = $query.'rfc = ?';
                array_push($parameters, strtoupper($alldata['rfc_value']));
            }
        }
        else
        {
            $num = 0;

            if (array_key_exists('nombre_value',$alldata) && isset($alldata['nombre_value'])){
                $query = $query."contribuyente like ?";
                array_push($parameters, '%'.$alldata['nombre_value'].'%');
                $num += 1;
            }

            if (array_key_exists('oficio_value',$alldata) && isset($alldata['oficio_value'])){
                if ($num != 0)
                    $query = $query.' AND oficio = ? ';
                else
                    $query = $query.' oficio = ? ';
                array_push($parameters, $alldata['oficio_value']);
                $num += 1;
            }

            if (array_key_exists('estado_value',$alldata) && isset($alldata['estado_value'])){
                 if ($num != 0)
                    $query = $query.' AND tipo in (?';
                else
                    $query = $query.' tipo in (?';

                array_push($parameters, $alldata['estado_value'][0]);
                for ($i = 1; $i < count($alldata['estado_value']); $i++ )
                {
                    $query = $query.',?';
                    array_push($parameters, $alldata['estado_value'][$i]);
                }
                 $query = $query.') ';
                 $num += 1;
            }

            //by sat
            if ($alldata['by_sat'] == 1){
                if ($alldata['by_sat_specific'] == 1){
                    if (array_key_exists('fecha_esp_sat',$alldata) && isset($alldata['fecha_esp_sat']))
                    {
                        if ($num != 0)
                            $query = $query.' AND fecha_sat = ? ';
                        else
                            $query = $query.' fecha_sat = ? ';
                        array_push($parameters, $alldata['fecha_esp_sat']);
                        $num += 1;
                    }
                }
                else
                {
                    if (array_key_exists('fecha_ini_sat',$alldata) && isset($alldata['fecha_ini_sat']) && array_key_exists('fecha_fin_sat',$alldata) && isset($alldata['fecha_fin_sat']))
                    {
                        if ($num != 0)
                            $query = $query.' AND fecha_sat BETWEEN STR_TO_DATE(?,"%Y-%m-%d") AND STR_TO_DATE(?,"%Y-%m-%d") ';
                        else
                            $query = $query.' fecha_sat BETWEEN STR_TO_DATE(?,"%Y-%m-%d") AND STR_TO_DATE(?,"%Y-%m-%d") ';
                        array_push($parameters, $alldata['fecha_ini_sat']);
                        array_push($parameters, $alldata['fecha_fin_sat']);
                        $num += 1;
                    }
                }
            }

            //by dof
            if ($alldata['by_dof'] == 1){
                if ($alldata['by_dof_specific'] == 1){
                    if (array_key_exists('fecha_esp_dof',$alldata) && isset($alldata['fecha_esp_dof']))
                    {
                        if ($num != 0)
                            $query = $query.' AND fecha_dof = ? ';
                        else
                            $query = $query.' fecha_dof = ? ';
                        array_push($parameters, $alldata['fecha_esp_dof']);
                        $num += 1;
                    }
                }
                else
                {
                    if (array_key_exists('fecha_ini_dof',$alldata) && isset($alldata['fecha_ini_dof']) && array_key_exists('fecha_fin_dof',$alldata) && isset($alldata['fecha_fin_dof']))
                    {
                        if ($num != 0)
                            $query = $query.' AND fecha_dof BETWEEN ? AND ? ';
                        else
                            $query = $query.' fecha_dof BETWEEN STR_TO_DATE(?,"%Y-%m-%d") AND STR_TO_DATE(?,"%Y-%m-%d") ';
                        array_push($parameters, $alldata['fecha_ini_dof']);
                        array_push($parameters, $alldata['fecha_fin_dof']);
                        $num += 1;
                    }
                }
            }
        }

        Log::info($query);
        Log::info($parameters);

        $query_result = \DB::select($query,$parameters);

        Log::info($query_result);

        $registros69 = array(
            array('rfc'=>'rrrrr', 'contribuyente'=>'rrrrr','tipo'=>'rrrr', 'oficio'=>'rrrr','fecha_sat'=>'rrrr','fecha_dof'=>'rrr','url_oficio'=>'rrrr','url_anexo'=>'rrrr'),
            array('rfc'=>'aaaaa', 'nombre'=>'aaaa','estado'=>'aaaa','fecha_sat'=>'aaaa','fecha_dof'=>'aaaa','url_oficio'=>'aaaa','url_anexo'=>'aaaaa'),
            array('rfc'=>'bbbbb', 'nombre'=>'bbbb','estado'=>'bbbb','fecha_sat'=>'bbbbb','fecha_dof'=>'bbbb','url_oficio'=>'bbbb','url_anexo'=>'bbbb'),
        );

        $response = array(
            'status' => 'Success',
            'msg' => 'Registers returned',
            'response69' => $query_result);

        return \Response::json($response);
    }


    public function getmax69(Request $request)
    {

        //conformacion de consulta para control
        $alldata = null;
        $alldata = $request->all();
        $parameters = [];
        $query = 'select MAX(fecha_sat) as fecha from `69`';

        $query_result = \DB::select($query,$parameters);

        $response = array(
            'status' => 'Success',
            'msg' => 'Registers returned',
            'response69' => $query_result);

        return \Response::json($response);
    }


    public function generateRandStr_md5($length) {
        $randStr = strtoupper(md5(rand(0, 1000000))); 
        $rand_start = rand(5,strlen($randStr)); 
        if($rand_start+$length > strlen($randStr)) {
               $rand_start -= $length; 
        } if($rand_start == strlen($randStr)) {
               $rand_start = 1; 
        }
        $randStr = strtoupper(substr(md5($randStr), $rand_start, $length));
        return $randStr; 
    }

    public function mailAccount(Request $request)
    {
        $alldata = $request->all();
        $uniq_id = '';
        if(array_key_exists('rfc_account',$alldata) && array_key_exists('rfc_client',$alldata)){
            $account_mails = Cimail::where('cim_rfc_account',$alldata['rfc_account'])->where('cim_rfc_client',$alldata['rfc_client'])->get();
            if(count($account_mails) > 0){
                foreach ($account_mails as $am_obj) {
                    if(array_key_exists('account_prefix',$alldata)){
                        $am_obj->cim_account_prefix = $alldata['account_prefix'];
                    }
                    $am_obj->save();
                }
            }else{
                $account_mails = new Cimail();
                $account_mails->cim_rfc_account = $alldata['rfc_account'];
                $account_mails->cim_rfc_client = $alldata['rfc_client'];
                if(array_key_exists('account_prefix',$alldata)){
                    $account_mails->cim_account_prefix = $alldata['account_prefix'];
                }
                //$uniq_id = 'boveda-'.uniqid().'@advans.mx';
                $uniq_id = 'boveda-'.$this->generateRandStr_md5(8).'@advans.mx';
                $account_mails->cim_mail = $uniq_id;
                $account = Account::where('cta_num',$alldata['rfc_account'])->get();
                if(count($account) > 0){
                    $account_mails->cim_account_id = $account[0]['id'];
                }
                $account_mails->save();
            }
            
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Mail created',
            'uniq_id' => $uniq_id
        );
        return \Response::json($response);
    }

    public function delMailAccount(Request $request)
    {
        $alldata = $request->all();
        if(array_key_exists('uniq_id',$alldata)){
            $account_mails = Cimail::where('cim_mail',$alldata['uniq_id'])->get();
            foreach ($account_mails as $account_mail) {
                $account_mail->delete();
            }
            
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Mail deleted'
        );
        return \Response::json($response);
    }
}
