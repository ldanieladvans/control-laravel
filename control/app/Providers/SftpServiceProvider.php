<?php

namespace App\Providers;
use Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\ServiceProvider;

class SftpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('sftp', function($app, $config) {
            unset($config['driver']);
            foreach($config as $key => $value) {
                if(!strlen($value)) {
                    unset($config[$key]);
                }
            }
            $adapter = new SftpAdapter($config);
            return new Filesystem($adapter);
        });
    }

   /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}