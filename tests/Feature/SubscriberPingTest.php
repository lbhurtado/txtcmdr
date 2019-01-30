<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Charging\Jobs\ChargeAirtime;
use App\Missive\Domain\Models\Contact;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Notifications\CommanderTestUpdated;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Missive\Domain\Repositories\ContactRepository;

class SubscriberPingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $commander;

    protected $destination;

    function setup()
    {
        parent::setUp();
        $this->faker = $this->makeFaker('en_PH');
        $this->artisan('db:seed',['--class' => 'AirtimeSeeder']);
        $this->commander = factory(Contact::class)->create(['mobile' => $this->generateMobile()]);
        $this->destination = $this->generateMobile();
        $this->endpoint = $this->getEndpoint();
    }

    /** @test */
    function commander_can_send_test_command()
    {
        $command = $message = 'ping';
        $from = $this->commander->mobile;
        $to = $this->destination;

        Queue::fake();
        Notification::fake();
        Notification::assertNothingSent();

        $this->json('POST', $this->endpoint, $this->getJsonData($command, $from, $to))
            ->assertStatus(200)
            ->assertJson(['data' => compact('from', 'to', 'message')])
            ;

        Notification::assertSentTo($this->commander, CommanderTestUpdated::class);
        Queue::assertPushed(ChargeAirtime::class); 
    }
}
