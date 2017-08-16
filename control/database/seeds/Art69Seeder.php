<?php

use Illuminate\Database\Seeder;

class Art69Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        exec("mysql -u ".env('DB_USERNAME', 'app-advans')." -p".env('DB_PASSWORD', 'XL.WE2maYF58u.N')." -h ".env('DB_HOST', '10.224.118.195')." ".env('DB_DATABASE', 'control')." < anexo_69.sql");

    }
}
