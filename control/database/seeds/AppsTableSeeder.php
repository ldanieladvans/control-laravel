<?php

use Illuminate\Database\Seeder;
use App\Apps;

class AppsTableSeeder extends Seeder
{

	public function createapps(){
		Apps::create([
		    'name' => 'Contabilidad',
		    'code' => 'cont',
		]);

		Apps::create([
		    'name' => 'Boveda',
		    'code' => 'bov',
		]);

		Apps::create([
		    'name' => 'Nomina',
		    'code' => 'nom',
		]);

		Apps::create([
		    'name' => 'PLD',
		    'code' => 'pld',
		]);

		Apps::create([
		    'name' => 'Control de Calidad',
		    'code' => 'cc',
		]);

		Apps::create([
		    'name' => 'Notaria',
		    'code' => 'not',
		]);

		Apps::create([
		    'name' => 'Facturacion Electronica',
		    'code' => 'fact',
		]);
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createapps();
    }
}
