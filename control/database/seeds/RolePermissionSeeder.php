<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\User;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    
	public function createroles(){
		//TODO here goes the app roles
		$adminRole = Role::create([
		    'name' => 'App',
		    'slug' => 'app',
		]);

		$moderatorRole = Role::create([
		    'name' => 'Api',
		    'slug' => 'api',
		]);

		return $adminRole->id;
	}

	public function createpermissions(){
		//TODO here goes the app permissions
		$createUsersPermission = Permission::create([
		    'name' => 'Create users',
		    'slug' => 'create.users',
		    'description' => '', // optional
		]);

		$deleteUsersPermission = Permission::create([
		    'name' => 'Delete users',
		    'slug' => 'delete.users',
		]);
	}

	public function createsuperuser($app_role_id){
		//TODO here goes the app roles
		$adminUser = User::create([
		    'name' => 'Admin',
		    'usrc_nick' => 'admin',
		    'email' => 'control.admin@advans.mx', 
		    'password' => bcrypt('Admin123*'),
		    'usrc_admin' => 1, 
		]);

		DB::table('role_user')->insert([
            ['role_id' => $app_role_id, 'user_id' => $adminUser->id, 'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]
        ]);
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_role_id = $this->createroles();
        $this->createpermissions();
        $this->createsuperuser($app_role_id);
    }
}
