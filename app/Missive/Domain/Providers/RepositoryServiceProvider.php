<?php

namespace App\Missive\Domain\Providers;

use Illuminate\Support\ServiceProvider;
use App\Missive\Domain\Repositories\{SMSRepository, SMSRepositoryEloquent};

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
        $this->app->bind(SMSRepository::class, SMSRepositoryEloquent::class);
    }
}
