<?php

namespace App\Providers;

use App\Business\QuickFs\IQuickFSClient;
use App\Business\QuickFs\QuickFSClient;
use Illuminate\Support\ServiceProvider;

class QuickFSClientProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            IQuickFSClient::class,
            fn($app) => new QuickFSClient(
                $app['config']['quickfs.auth-header'],
                $app['config']['quickfs.api-key'],
                $app['config']['quickfs.base-uri'],
            )
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
