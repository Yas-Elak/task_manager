<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'layouts.master',
            'App\Http\ViewComposers\NotificationsComposer'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
