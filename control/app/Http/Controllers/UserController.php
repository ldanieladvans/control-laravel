<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Distributor;
use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    use RegistersUsers;
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function customvalidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'usrc_nick' => 'required|string|max:15|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function customcreate(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'usrc_nick' => $data['usrc_nick'],
        ]);
    }


    public function customregister(Request $request, $values)
    {
        $this->customvalidator($values)->validate();
        event(new Registered($user = $this->customcreate($values)));
        $this->registered($request, $user);
        return $user;
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
            $users = User::all();
        }elseif($logued_user->usrc_super){
            $users = User::where('usrc_admin',0)->get();
        }else{
            $users = User::where('usrc_distrib_id',$logued_user->usrc_distrib_id)->get();
        }
        $roles = Role::all();
        $permissions = Permission::all();
        return view('appviews.usershow',['users'=>$users,'roles'=>$roles,'permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distributors = Distributor::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('appviews.usercreate',['distributors'=>$distributors,'roles'=>$roles,'permissions'=>$permissions]);
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
        $user = $this->customregister($request,$alldata);
        $file     = false;
        if(array_key_exists('usrc_pic',$alldata)){
            $file     = request()->file('usrc_pic');
            $path = $request->file('usrc_pic')->storeAs('public', $user->id.'.'.$file->getClientOriginalName());
        }
        if($file!=false){
            $user->usrc_pic = $user->id.'.'.$file->getClientOriginalName();
        }
        if(array_key_exists('usrc_tel',$alldata) && isset($alldata['usrc_tel'])){
            $user->usrc_tel = $alldata['usrc_tel'];
        }
        if(array_key_exists('usrc_super',$alldata) && isset($alldata['usrc_super'])){
            $user->usrc_super = $alldata['usrc_super'];
        }
        if(array_key_exists('usrc_distrib_id',$alldata) && isset($alldata['usrc_distrib_id'])){
            if($alldata['usrc_distrib_id'] != 'null'){
                $user->usrc_distrib_id = $alldata['usrc_distrib_id'];
            }           
        }
        $user->save();
        if(array_key_exists('roles',$alldata)){
            foreach ($alldata['roles'] as $rol) {
                $rolobj = Role::find($rol);
                $user->attachRole($rolobj);
            }
        }
        if(array_key_exists('permisos',$alldata)){
            foreach ($alldata['permisos'] as $perm) {
                $permobj = Permission::find($perm);
                $user->attachPermission($permobj);
            }
        }        
        $fmessage = 'Se ha creado el usuario: '.$alldata['name'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'store',$fmessage);
        return redirect()->route('user.index');
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
        $user = User::findOrFail($id);
        if(!$this->controllerUserCanAccess(Auth::user(),$user->usrc_distrib_id)){
            return view('errors.403');
        }
        $distributors = Distributor::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('appviews.useredit',['distributors'=>$distributors,'roles'=>$roles,'permissions'=>$permissions,'user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $alldata = $request->all();
        $file     = false;
        if(!$this->controllerUserCanAccess(Auth::user(),$user->usrc_distrib_id)){
            return view('errors.403');
        }
        if(array_key_exists('usrc_pic',$alldata)){
            $file     = request()->file('usrc_pic');
            $path = $request->file('usrc_pic')->storeAs(
            'public', $user->id.'.'.$file->getClientOriginalName()
        );
        }else{
            if(array_key_exists('deleted_pic',$alldata)){
                if($alldata['deleted_pic']=='1'){
                    $user->usrc_pic = 'default_avatar_male.jpg';
                }
            }
        }
        if($file!=false){
            $user->usrc_pic = $user->id.'.'.$file->getClientOriginalName();
        }
        if(array_key_exists('usrc_tel',$alldata) && isset($alldata['usrc_tel'])){
            $user->usrc_tel = $alldata['usrc_tel'];
        }
        if(array_key_exists('usrc_super',$alldata) && isset($alldata['usrc_super'])){
            $user->usrc_super = $alldata['usrc_super'];
        }
        if(array_key_exists('usrc_distrib_id',$alldata) && isset($alldata['usrc_distrib_id'])){
            if($alldata['usrc_distrib_id'] != 'null'){
                $user->usrc_distrib_id = $alldata['usrc_distrib_id'];
            }           
        }
        if(array_key_exists('name',$alldata) && isset($alldata['name'])){
            $user->name = $alldata['name'];
        }
        if(array_key_exists('usrc_nick',$alldata) && isset($alldata['usrc_nick'])){
            $user->usrc_nick = $alldata['usrc_nick'];
        }
        if(array_key_exists('email',$alldata) && isset($alldata['email'])){
                $user->email = $alldata['email'];       
        }
        if(array_key_exists('usrc_super',$alldata) && isset($alldata['usrc_super'])){
                $user->usrc_super = $alldata['usrc_super'];       
        }
        $user->save();
        $user->detachAllRoles();
        if(array_key_exists('roles',$alldata)){
            
            foreach ($alldata['roles'] as $rol) {
                $rolobj = Role::find($rol);
                $user->attachRole($rolobj);
            }
        }
        $user->detachAllPermissions();
        if(array_key_exists('permisos',$alldata)){
            
            foreach ($alldata['permisos'] as $perm) {                
                $permobj = Permission::find($perm);
                $user->attachPermission($permobj);

            }
        }
        $fmessage = 'Se ha actualizado el usuario: '.$alldata['name'];
        \Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'update',$fmessage);
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,Request $request)
    {
        if (isset($user)){
            if(!$this->controllerUserCanAccess(Auth::user(),$user->usrc_distrib_id)){
                return view('errors.403');
            }
            if($user->usrc_admin == 1){
                $fmessage = 'No se puede eliminar el usuario administrador';
                \Session::flash('message',$fmessage);
            }else{
                $fmessage = 'Se ha eliminado el usuario: '.$user->name;
                \Session::flash('message',$fmessage);
                $this->registeredBinnacle($request,'destroy',$fmessage);
                $user->delete();
            }
        }
        return redirect()->route('user.index');
    }

    public function permsbyroles(Request $request)
    {
        $rolestr = '';
        $permstr = '';
        $alldata = $request->all();
        $return_array = array();
        if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){
            foreach ($alldata['selected'] as $select) {
                $role = Role::find((int)$select);
                $rolestr = $rolestr + $role->name + ',';
                $tests = false;
                if (isset($role)){
                    $tests = $role->permissions()->get();
                    foreach ($tests as $test) {
                        array_push($return_array, $test->id);
                        $permstr = $permstr . $test->name . ',';
                    }
                }
            }
        }
        $fmessage = 'Se han asignado los permisos: '.$permstr.' a los roles: '.$rolestr;
        //\Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'permsbyroles',$fmessage);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'roles' => $return_array,
        );
        return \Response::json($response);
    }

    public function changepass(Request $request)
    {
        $alldata = $request->all();
        $return_array = array();
        $user = false;
        if(array_key_exists('user',$alldata) && isset($alldata['user'])){
            $user = User::find($alldata['user']);
        }
        if($user!=false){
            if(array_key_exists('password',$alldata) && isset($alldata['password'])){
                $user->password = bcrypt($alldata['password']);
            }
        }
        $user->save();
        $fmessage = 'Se ha cambiado la contraseña del usuario: '.$user->name;
        //\Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'changepass',$fmessage);
        $response = array(
            'status' => 'success',
            'msg' => 'Se cambió la contraseña satisfactoriamente',
            'user' => $alldata['user'],
        );
        return \Response::json($response);
    }

    public function assignroles(Request $request)
    {
        $rolestr = '';
        $permstr = '';
        $alldata = $request->all();
        $return_array = array();
        $user = false;
        $perms = false;
        if(array_key_exists('user',$alldata) && isset($alldata['user'])){
            $user = User::find($alldata['user']);
        }
        if($user!=false){
            $user->detachAllRoles();
            if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){  
                foreach ($alldata['selected'] as $rol) {
                    $role = Role::find($rol);
                    $rolestr = $rolestr . $role->name . ',';
                    $user->attachRole($role);
                    $perms = $role->permissions()->get();
                    foreach ($perms as $perm) {
                        $user->attachPermission($perm);
                    }
                }
            }
        }
        $fmessage = 'Se han asignado los roles: '.$rolestr.' al usuario: '.($user ? $user->name : '');
        //\Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'assignroles',$fmessage);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'user' => $alldata['user'],
        );
        return \Response::json($response);
    }

    public function assignperms(Request $request)
    {
        $permstr = '';
        $alldata = $request->all();
        $return_array = array();
        $user = false;
        if(array_key_exists('user',$alldata) && isset($alldata['user'])){
            $user = User::find($alldata['user']);
        }
        if($user!=false){
            $user->detachAllPermissions();
            if(array_key_exists('selected',$alldata) && isset($alldata['selected'])){  
                foreach ($alldata['selected'] as $perm) {
                    $permobj = Permission::find($perm);
                    $permstr = $permstr . $permobj->name . ',';
                    DB::table('permission_user')->insert([
                        ['permission_id' => $permobj->id, 'user_id' => $user->id, 'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]
                    ]);
                }
            }
        }
        $fmessage = 'Se han asignado los permisos: '.$permstr.' al usuario: '.($user ? $user->name : '');
        //\Session::flash('message',$fmessage);
        $this->registeredBinnacle($request,'assignperms',$fmessage);
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'user' => $alldata['user'],
        );
        return \Response::json($response);
    }
}
