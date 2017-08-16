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
        exec("mysql -u ".env('DB_USERNAME', 'root')." -p".env('DB_PASSWORD', 's3cur3mysql')." -h ".env('DB_HOST', '127.0.0.1')." ".env('DB_DATABASE', 'control')." < anexo_69.sql");
    }
}
