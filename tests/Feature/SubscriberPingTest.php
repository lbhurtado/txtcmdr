<?php

namespace Tests\Feature;

use Tests\TestCase;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Missive\Domain\Repositories\ContactRepository;
use App\Missive\Domain\Models\Contact;

class SubscriberPingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function setup()
    {
        parent::setUp();
        $this->faker = $this->makeFaker('en_PH');

        $this->artisan('db:seed',['--class' => 'AirtimeSeeder']);
    }

    /** @test */
    function globe_connect_can_send_subscriber_data_to_redirect()
    {

        $mobile = PhoneNumber::make($this->faker->mobileNumber)->ofCountry('PH')->formatE164();

        factory(Contact::class)->create(compact('mobile'));

        $response = $this->json('POST', 'api/webhook/sms/globe', [
            'inboundSMSMessageList' => [
                'inboundSMSMessage' => [
                    [
                        'destinationAddress' => 'tel:21582402',
                        'senderAddress' => $mobile,
                        'message' => 'ping',
                    ],
                ],
            ],
        ]);

        $response
            ->assertStatus(200)
//            ->assertJson([
//                'data' => [
//                    'subscriber_number' => $mobile = PhoneNumber::make($mobile)->ofCountry('PH')->formatE164(),
//                    'access_token' => $token,
//                ],
//            ])
        ;

//        tap(app(ContactRepository::class), function ($contacts) use ($mobile, $token) {
//            $this->assertNotNull($contact = $contacts->findByField('mobile', $mobile)->first());
//            $this->assertEquals($contact->token, $token);
//        });
    }
}
