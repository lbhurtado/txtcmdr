<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Missive\Domain\Repositories\ContactRepository;

class ContactTest extends TestCase
{
	use RefreshDatabase, WithFaker;

    /** @test */
    public function contact_has_mobile()
    {
        tap(app(ContactRepository::class), function ($contacts) {
        	$mobile = $this->faker->phoneNumber;
        	$contact = $contacts->create(compact('mobile'));
        	$this->assertEquals($mobile, $contact->mobile);	
        });
    }
}
