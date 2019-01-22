<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Missive\Domain\Models\Contact;

class ContactTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function contact_has_mobile()
    {
        $contact = Contact::create(['mobile' => '639189362340']);
        
        $this->assertEquals($contact->mobile, '639189362340');
    }
}
