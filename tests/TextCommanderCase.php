<?php

namespace Tests;

use App\Campaign\Domain\Models\Group;
use App\Missive\Domain\Models\Contact;
use App\Charging\Domain\Models\Airtime;
use App\Providers\RouteServiceProvider;
use App\Charging\Domain\Classes\AirtimeKey;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


abstract class TextCommanderCase extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $commander;

    protected $destination;

    function setup()
    {
        parent::setUp();

        factory(Airtime::class)->create(['key' => AirtimeKey::SMS]);

        $this->commander = factory(Contact::class)->create(['mobile' => $this->generateMobile()]);
        $this->destination = $this->generateMobile();
        $this->endpoint = $this->getEndpoint();
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

    function conjureGroup()
    {
        return factory(Group::class)->create();
    }

    function conjureGroups($number)
    {
        return factory(Group::class, $number)->create();
    }

    function conjureContact()
    {
        return factory(Contact::class)->create();
    }

    function conjureContacts($number)
    {
        return factory(Contact::class, $number)->create();
    }
}