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

class UserController extends Controller
{

    use RegistersUsers;
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
        $users = User::all();
        return view('appviews.usershow',['users'=>$users]);
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
        $file     = request()->file('usrc_pic');
        if(array_key_exists('usrc_pic',$alldata)){
            $path = $request->file('usrc_pic')->storeAs(
            'public', $user->id.'.'.$file->getClientOriginalName()
        );
        }
        

        if($path!=false){
            $user->usrc_pic = $file->getClientOriginalName();
        }

        if(array_key_exists('usrc_tel',$alldata) && isset($alldata['usrc_tel'])){
            $user->usrc_tel = $alldata['usrc_tel'];
        }

        if(array_key_exists('usrc_super',$alldata) && isset($alldata['usrc_super'])){
            $user->usrc_super = $alldata['usrc_super'];
        }

        if(array_key_exists('usrc_distrib_id',$alldata) && isset($alldata['usrc_distrib_id'])){
            $user->usrc_distrib_id = $alldata['usrc_distrib_id'];
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
        $this->registeredBinnacle($request,'create',$fmessage);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
