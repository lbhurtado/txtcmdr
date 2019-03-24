<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Charging\Jobs\ChargeAirtime;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Missive\Domain\Repositories\ContactRepository;

class SubscriberOptinTest extends TestCase
{
    function setup()
    {
        parent::setUp();

        $this->endpoint = $this->getEndpoint('redirect');
    }

    /** @test */
    function globe_connect_can_send_subscriber_data_to_redirect_and_persist()
    {
        /*** arrange ***/
        $access_token = $this->faker->md5;
        $subscriber_number = $this->generateMobile();
        $data = compact('access_token', 'subscriber_number');

        /*** act ***/
        Queue::fake();

        /*** assert ***/
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(200)
            ->assertJson(compact('data'));
        
        tap(app(ContactRepository::class), function ($contacts) use ($subscriber_number, $access_token) {
            $this->assertNotNull($contact = $contacts->findByField('mobile', $subscriber_number)->first());
            $this->assertEquals($contact->token, $access_token);
        });

        Queue::assertNotPushed(ChargeAirtime::class);
    }
}
