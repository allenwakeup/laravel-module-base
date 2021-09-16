<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Base\Providers;

use Illuminate\Support\Facades\Route;
use Goodcatch\Modules\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Goodcatch\\Modules\\Base\\Http\\Controllers\\';

    protected $path;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct ($app)
    {
        parent::__construct ($app);

        $this->initRoute ();

    }

    protected function initRoute ()
    {
        $this->path = __DIR__ . '/../../routes';
    }

    protected function getPath ($name = null)
    {
        return $this->path . '/' . (isset ($name) ? $name : 'web') . '.php';
    }


    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map ()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group($this->getPath ());
    }


    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes ()
    {
        Route::prefix ('api')
            ->middleware ('api')
            ->namespace ($this->namespace)
            ->group ($this->getPath ('api'));
    }

}
