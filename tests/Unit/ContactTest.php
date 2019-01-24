<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Missive\Domain\Repositories\ContactRepository;
use App\Campaign\Domain\Models\Area;
use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Models\Tag;

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

    /** @test */
    public function contact_has_areas()
    {
        $area = factory(Area::class)->create();
        $contact = factory(Contact::class)->create();
        $contact->syncAreas($area->name);
        $this->assertEquals($area->name, $contact->areas->pluck('name')[0]);
    }

    /** @test */
    public function contact_can_create_just_one_and_remove_it()
    {
        $code = $this->faker->word;
        $contact = factory(Contact::class)->create();
        $this->assertEquals($contact->tag()->count(), 0);

        $tag = $contact->tag()->create(compact('code'));
        
        $this->assertEquals($contact->tag()->count(), 1);
        $this->assertEquals($code, $tag->code);
        $this->assertEquals($contact->id, $tag->tagger->id);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $contact->tag()->create(['code' => $this->faker->word]);
    }
}
