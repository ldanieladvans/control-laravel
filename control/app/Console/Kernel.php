<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            Log::info('************************************* Init Cron *****************************************');
            $rec_ctas_id_arr = array();
            $rec_ctas = \DB::table('cta')->where('cta_estado','Activa')->where('cta_recursive',1)->get();
            foreach ($rec_ctas as $rec) {
                array_push($rec_ctas_id_arr, $rec->id)
            }
            $rec_ctas_dets = \DB::table('accounttl')->whereIn('cta_id',$rec_ctas_id_arr)->where('acctl_f_fin',date('Y-m-d'))->get();
            foreach ($rec_ctas_dets as $dets) {
                $acctl = new AccountTl();
                $acctl->acctl_estado = 'Pendiente';
                $acctl->cta_id = $dets->cta_id;
                $acctl->acctl_f_ini = mktime(0, 0, 0, date("m"), date("d")+1,date("Y"));
                $acctl->acctl_f_fin = mktime(0, 0, 0, date("m")+3, date("d"),date("Y"));
                $acctl->acctl_f_corte = mktime(0, 0, 0, date("m")+3, date("d"),date("Y"));
                $acctl->save();
            }
            Log::info('************************************* End Cron *****************************************');
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
