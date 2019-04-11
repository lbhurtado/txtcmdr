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
        $this->app->bind(\App\Campaign\Domain\Repositories\CampaignRepository::class, \App\Campaign\Domain\Repositories\CampaignRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\TagRepository::class, \App\Campaign\Domain\Repositories\TagRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\AlertRepository::class, \App\Campaign\Domain\Repositories\AlertRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\CheckinRepository::class, \App\Campaign\Domain\Repositories\CheckinRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\IssueRepository::class, \App\Campaign\Domain\Repositories\IssueRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\CategoryRepository::class, \App\Campaign\Domain\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Campaign\Domain\Repositories\LeadRepository::class, \App\Campaign\Domain\Repositories\LeadRepositoryEloquent::class);
        //:end-bindings:
    }
}
