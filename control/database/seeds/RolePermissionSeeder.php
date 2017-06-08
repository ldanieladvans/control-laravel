<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    
	public function createroles(){
		//TODO here goes the app roles
		$adminRole = Role::create([
		    'name' => 'Admin',
		    'slug' => 'admin',
		    'description' => '', // optional
		    'level' => 1, // optional, set to 1 by default
		]);

		$moderatorRole = Role::create([
		    'name' => 'Forum Moderator',
		    'slug' => 'forum.moderator',
		]);
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

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createroles();
        $this->createpermissions();
    }
}
