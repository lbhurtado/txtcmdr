<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(\App\Missive\Domain\Repositories\ContactRepository::class, \App\Missive\Domain\Repositories\ContactRepositoryEloquent::class);
        $this->app->bind(\App\Charging\Domain\Repositories\AirtimeRepository::class, \App\Charging\Domain\Repositories\AirtimeRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\GroupRepository::class, \App\Campaign\Domain\Repositories\GroupRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\AreaRepository::class, \App\Campaign\Domain\Repositories\AreaRepositoryEloquent::class);
        //:end-bindings:
    }
}
