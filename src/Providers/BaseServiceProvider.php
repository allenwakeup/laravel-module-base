<?php

namespace Goodcatch\Modules\Base\Providers;

use Goodcatch\Modules\Base\Services\MenuService;
use Illuminate\Support\ServiceProvider;

/**
 * Class LightcmsServiceProvider
 *
 * the main service provider that configured, so that laravel-modules requires.
 *
 * @package Goodcatch\Modules\Providers
 */
class BaseServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ResourcesServiceProvider::class);

        $this->app->singleton('MenuService', function ($app) {
            return new MenuService($app);
        });
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), ['../../resources/views']), 'base');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/../../resources/lang',
            'laravel-modules'
        );
    }


}
