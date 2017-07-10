<?php

use Illuminate\Database\Seeder;
use App\Appcontrol;

class AppsSeeder extends Seeder
{
    
	public function createapps(){
		//TODO here goes the app roles


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(CpMexSeeder::class);
    }
}
