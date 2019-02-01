<?php

namespace App\App\Providers;

use Opis\Events\EventDispatcher;
use App\App\Services\TextCommander;
use Illuminate\Support\ServiceProvider;
use App\GlobeLabs\Services\GlobeConnect;
use App\GlobeLabs\Channels\GlobeConnectChannel;
use App\Campaign\Notifications\BaseNotification;
use App\Missive\Domain\{Models\SMS, Observers\SMSObserver};
use App\Missive\Domain\Repositories\{SMSRepository, SMSRepositoryEloquent};
use App\Campaign\Domain\Repositories\{TagRepository, TagRepositoryEloquent};
use App\Campaign\Domain\Repositories\{AreaRepository, AreaRepositoryEloquent};
use App\Campaign\Domain\Repositories\{AlertRepository, AlertRepositoryEloquent};
use App\Campaign\Domain\Repositories\{GroupRepository, GroupRepositoryEloquent};
use App\Missive\Domain\Repositories\{ContactRepository, ContactRepositoryEloquent};
use App\Charging\Domain\Repositories\{AirtimeRepository, AirtimeRepositoryEloquent};
use App\Campaign\Domain\Repositories\{CampaignRepository, CampaignRepositoryEloquent};

class TextCommanderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        SMS::observe(SMSObserver::class);

        $this->app
            ->when (GlobeConnectChannel::class)
            ->needs(GlobeConnect::class)
            ->give (function () {
                return new GlobeConnect();
            });

        $this->app
            ->when (BaseNotification::class)
            ->needs('$signature')
            ->give (function () {
                return config('txtcmdr.notification.signature');
            });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SMSRepository::class, SMSRepositoryEloquent::class);
        $this->app->bind(ContactRepository::class, ContactRepositoryEloquent::class);
        $this->app->bind(AirtimeRepository::class, AirtimeRepositoryEloquent::class);
        $this->app->bind(GroupRepository::class, GroupRepositoryEloquent::class);
        $this->app->bind(AreaRepository::class, AreaRepositoryEloquent::class);
        $this->app->bind(CampaignRepository::class, CampaignRepositoryEloquent::class);
        $this->app->bind(TagRepository::class, TagRepositoryEloquent::class);
        $this->app->bind(AlertRepository::class, AlertRepositoryEloquent::class);

        $this->app->singleton(EventDispatcher::class);
        $this->app->singleton('txtcmdr', function ($app) {
            return tap(new TextCommander(), function ($txtcmdr) {

            });
        });
        $this->app->singleton(TextCommander::class, function ($app) {
            return $app->make('txtcmdr');
        });
    }
}
