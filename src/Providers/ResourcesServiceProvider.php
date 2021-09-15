<?php

namespace Goodcatch\Modules\Base\Providers;

use Illuminate\Support\ServiceProvider;

class ResourcesServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {

        $this->registerViews ();
    }

    public function registerViews ()
    {
        if ($this->app->runningInConsole ()) {
            $src = __DIR__ . '/../..';
            $this->publishes ([
                $src . '/public/dist' =>  public_path('dist/module-base')
            ], 'laravel-modules');
        }
    }

}
