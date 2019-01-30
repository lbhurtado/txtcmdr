<?php

namespace Tests\Feature;

use Tests\TestCase;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Missive\Domain\Repositories\ContactRepository;

class SubscriberOptinTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function setup()
    {
        parent::setUp();
        $this->faker = $this->makeFaker('en_PH');
    }

    /** @test */
    function globe_connect_can_send_subscriber_data_to_redirect()
    {
        $token = $this->faker->md5;
        $mobile = $this->faker->mobileNumber;

        $response = $this->json('POST', 'api/webhook/redirect/globe', [
            'access_token' => $token,
            'subscriber_number' => $mobile
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'subscriber_number' => $mobile = PhoneNumber::make($mobile)->ofCountry('PH')->formatE164(),
                    'access_token' => $token,
                ],
            ]);

        tap(app(ContactRepository::class), function ($contacts) use ($mobile, $token) {
            $this->assertNotNull($contact = $contacts->findByField('mobile', $mobile)->first());
            $this->assertEquals($contact->token, $token);
        });
    }
}
