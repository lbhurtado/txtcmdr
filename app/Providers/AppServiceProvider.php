<?php

namespace App\Providers;

use App\App\Services\Router;
use Opis\Events\EventDispatcher;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use App\Missive\Domain\{Models\SMS, Observers\SMSObserver};
use App\Missive\Domain\Repositories\{SMSRepository, SMSRepositoryEloquent};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SMS::observe(SMSObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SMSRepository::class, SMSRepositoryEloquent::class);
        $this->app->singleton(EventDispatcher::class);

        $this->app->singleton('txtcmdr', function ($app) {

            $txtcmdr = new Router();

            return $txtcmdr;
        });
    }
}
