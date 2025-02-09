<?php

namespace MNobre\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\JetstreamServiceProvider;
use Laravel\Jetstream\Jetstream;


class RouteServiceProvider extends JetstreamServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Jetstream::ignoreRoutes();

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
