<?php

namespace Tests;

use App\Campaign\Domain\Models\Tag;
use App\Campaign\Domain\Models\Area;
use App\Charging\Jobs\ChargeAirtime;
use App\Campaign\Domain\Models\Alert;
use App\Campaign\Domain\Models\Group;
use Illuminate\Support\Facades\Queue;
use App\Missive\Domain\Models\Contact;
use App\Charging\Domain\Models\Airtime;
use App\Providers\RouteServiceProvider;
use App\Campaign\Domain\Classes\Command;
use App\Campaign\Domain\Models\Campaign;
use App\Charging\Domain\Classes\AirtimeKey;
use App\Campaign\Jobs\UpdateCommanderUpline;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Campaign\Jobs\Charge\ChargeCommanderOutgoingSMS;

abstract class TextCommanderCase extends TestCase
{
    use DatabaseTransactions;

    protected $commander;

    protected $destination;

    function setup()
    {
        parent::setUp();

//        factory(Airtime::class)->create(['key' => AirtimeKey::SMS]);

//        $this->commander = factory(Contact::class)->create(['mobile' => $this->generateMobile()]);
        $this->commander = $this->pickRandomContact();
        $this->destination = $this->generateMobile();
        $this->endpoint = $this->getEndpoint();
    }

    function getCommand($key)
    {
        return array_get(array_flip(Command::$mappings), $key);
    }

    function persistUpline()
    {
        return tap($this->conjureContact(), function ($contact) {
            (new UpdateCommanderUpline($this->commander, $contact))->handle();
        });
    }

    function assertCommandIssued($missive)
    {
        $this->json('POST', $this->endpoint, $this->getJsonData($message = $missive, $from = $this->commander->mobile, $to = $this->destination))
            ->assertStatus(200)
            ->assertJson(['data' => compact('from','to', 'message')])
        ;
    }

    //Re-define the routes for testing.
    //call this every time you need to access routes/txtcmdr.php
    //this will populate the allowed groups, areas, tags, etc.
    function redefineRoutes()
    {
        (new RouteServiceProvider($this->app))->map();
    }

    function conjureArea()
    {
        return factory(Area::class)->create();
    }

    function pickRandomArea()
    {
        return Area::all()->random(1)->first();
    }

    function conjureAreas($number)
    {
        return factory(Area::class, $number)->create();
    }

    function conjureGroup()
    {
        return factory(Group::class)->create();
    }

    function conjureGroups($number)
    {
        return factory(Group::class, $number)->create();
    }

    function pickRandomGroup()
    {
        return Group::all()->random(1)->first();
    }

    function conjureContact()
    {
        return factory(Contact::class)->create();
    }

    function pickRandomContact()
    {
        return Contact::all()->random(1)->first();
    }

    function conjureContacts($number)
    {
        return factory(Contact::class, $number)->create();
    }

    function conjureCampaign()
    {
        return factory(Campaign::class)->create();
    }

    function pickRandomCampaign()
    {
        return Campaign::all()->random(1)->first();
    }

    function conjureCampaigns($number)
    {
        return factory(Campaign::class, $number)->create();
    }

    function conjureTag()
    {
        return factory(Tag::class)->create();
    }

    function pickRandomTag()
    {
        return Tag::all()->random(1)->first();
    }

    function conjureTags($number)
    {
        return factory(Tag::class, $number)->create();
    }

    function conjureAlert()
    {
        return factory(Alert::class)->create();
    }

    function conjureAlerts($number)
    {
        return factory(Alert::class, $number)->create();
    }

    protected function assertAirtimeCharged()
    {
        Queue::assertPushed(ChargeAirtime::class, function ($job) {
            return
                ($job->commander->is($this->commander)) &&
                ($job->availment == AirtimeKey::INCOMING_SMS)
                ;
        });
        Queue::assertPushed(ChargeCommanderOutgoingSMS::class, function ($job) {
            return
                $job->commander->is($this->commander)
                ;
        });
    }
}
