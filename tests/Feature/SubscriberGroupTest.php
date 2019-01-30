<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\App\Jobs\ProcessCommand;
use App\Charging\Jobs\ChargeAirtime;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};

use App\Campaign\Jobs\UpdateCommanderGroup;

class SubscriberGroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    function setup()
    {
        parent::setUp();
        $this->artisan('db:seed');        
        // $this->artisan('db:seed',['--class' => 'AirtimeSeeder']);
        // $this->artisan('db:seed',['--class' => 'GroupSeeder']);
    }

    /** @test */
    function commander_can_send_tag_command()
    {
        $command = $message = "&personnel";
        $from = $this->commander->mobile;
        $to = $this->destination;

        Queue::fake();
        // Notification::fake();
        // Notification::assertNothingSent();

        $this->json('POST', $this->endpoint, $this->getJsonData($command, $from, $to))
            ->assertStatus(200)
            ->assertJson(['data' => compact('from', 'to', 'message')])
            ;

        // dd($this->commander->areas()->first());
        // Notification::assertSentTo($this->commander, CommanderTagUpdated::class);
        
        Queue::assertPushed(ProcessCommand::class); //not working
        Queue::assertPushed(ChargeAirtime::class); 
    }
}
