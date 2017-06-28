<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('rfc', function ($attribute, $value, $parameters, $validator) {
            $result = preg_match('/^[A-ZÑ&]{3}([0-9]{2})([0-1][0-9])([0-3][0-9])[A-Z0-9][A-Z0-9][0-9A]$/u', $value, $matches);
            if (!$result) {
               $result = preg_match('/^[A-ZÑ&]{4}([0-9]{2})([0-1][0-9])([0-3][0-9])[A-Z0-9][A-Z0-9][0-9A]$/u', $value, $matches);
                   if (!$result) {
                    return false;
                }
            }
            if ((int) $matches[1] <= 12) {
                $matches[1] = 2000 + (int) $matches[1];
            } else {
                $matches[1] = 1900 + (int) $matches[1];
            }

            return strtotime($matches[1] . '-' . $matches[2] . '-' . $matches[3]) ? true : false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
