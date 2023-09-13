<?php

namespace App\Providers;

use App\View\Composers\HelperComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
      if ($this->app->environment('production')) {
        $this->app['request']->server->set('HTTPS','on');
        URL::forceSchema('https');
    }
    }
}
