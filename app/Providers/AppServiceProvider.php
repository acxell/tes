<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for your application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes(); // This will load your API routes
        $this->mapWebRoutes(); // For web routes (if any)
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api') // This will apply the "api" prefix to all routes
            ->middleware('api') // This applies the api middleware
            ->namespace($this->namespace) // Use your controller's namespace
            ->group(base_path('routes/api.php')); // Load the routes from api.php
    }

    /**
     * Define the "web" routes for the application.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web') // This applies the web middleware
            ->namespace($this->namespace) // Use your controller's namespace
            ->group(base_path('routes/web.php')); // Load the routes from web.php
    }
}
