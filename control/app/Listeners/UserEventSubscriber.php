<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Log;
use App\Binnacle;

class UserEventSubscriber
{

    

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        Log::info('Showing user profile for user: ');
        $binnacle = new Binnacle();
        $binnacle->bitc_usrc_id = $event->user->id;
        $binnacle->bitc_fecha = date("Y-m-d H:i:s");
        $binnacle->bitc_tipo_op = 'access';
        $binnacle->bitc_ip = $binnacle->getrealip();
        $browser_arr = $binnacle->getBrowser();
        $binnacle->bitc_naveg = $browser_arr['name'].' '.$browser_arr['version'];
        $binnacle->bitc_modulo = '\Login';
        $binnacle->bitc_result = 'TODO';
        $binnacle->bitc_msj = 'Se ha accedido a la aplicación';
        $binnacle->bitc_dat = json_encode($_REQUEST);
        $binnacle->save();
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {

    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }

}