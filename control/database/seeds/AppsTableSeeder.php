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
		    'name' => 'Bóveda',
		    'code' => 'bov',
		]);

		Apps::create([
		    'name' => 'Nómina',
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
		    'name' => 'Notaría',
		    'code' => 'not',
		]);

		Apps::create([
		    'name' => 'Facturación Electrónica',
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
