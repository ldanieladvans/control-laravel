<?php

use Illuminate\Database\Seeder;
use App\Appcontrol;

class AppsSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(CpMexSeeder::class);
        $this->call(AppsTableSeeder::class);
    }
}
