<?php

namespace App\Missive\Domain\Providers;

use App\Missive\Domain\{
    Models\SMS, Observers\SMSObserver
};
use Illuminate\Support\ServiceProvider;


class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        SMS::observe(SMSObserver::class);
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
