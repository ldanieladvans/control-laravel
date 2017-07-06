<?php

use Illuminate\Database\Seeder;

use App\Cpmex;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CpMexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = file_get_contents(storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'CPdescarga.xls');
        
        Excel::load(storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'CPdescarga.xls', function($reader) {
        	$counter_sheet = 0;
		    // Loop through all sheets
			$reader->each(function($sheet,$counter_sheet) {

			    if($counter_sheet > 0){
			    	// Loop through all rows
			    	Log::info(date('Y-m-d H:i:s'));
				    $sheet->each(function($row) {
				    		
				    	$objcreated = Cpmex::create([
						    'd_codigo' => $row['d_codigo'],
						    'd_asenta' => $row['d_asenta'],
						    'd_tipo_asenta' => $row['d_tipo_asenta'],
						    'd_mnpio' => $row['d_mnpio'],
						    'd_estado' => $row['d_estado'],
						    'd_ciudad' => $row['d_ciudad'],
						    'd_cp' => $row['d_cp'],
						    'c_estado' => $row['c_estado'],
						    'c_oficina' => $row['c_oficina'],
						    'c_cp' => $row['c_cp'],
						    'c_tipo_asenta' => $row['c_tipo_asenta'],
						    'c_mnpio' => $row['c_mnpio'],
						    'id_asenta_cpcons' => $row['id_asenta_cpcons'],
						    'd_zona' => $row['d_zona'],
						    'c_cve_ciudad' => $row['c_cve_ciudad'],
						]);
				    });
			    }
			    $counter_sheet ++;

			});
			Log::info(date('Y-m-d H:i:s'));

		});

        

    }
}
