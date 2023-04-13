<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\ConfigService;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $configSrv = new ConfigService();
        $configs = $configSrv->getKeyValuePairs();
        
        View::share('configs', $configs->all());
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
