<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Domain\Repositories\TagRepository;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Models\{Tag, Group, Area, Campaign};

class TagTest extends TestCase
{
	use RefreshDatabase, WithFaker;

    /** @test */
    public function tag_has_code_and_tagger()
    {
        $code = $this->faker->name;
    	$tagger = factory(Contact::class)->create();

        tap(app(TagRepository::class)->makeModel(), function ($tag) use ($code, $tagger) {
        	$tag->code = $code;
        	$tag->tagger()->associate($tagger);
        	$tag->save();
        	$this->assertEquals($code, $tag->code);	
        	$this->assertEquals($tagger->name, $tag->tagger->name);
            $this->assertDatabaseHas('tags', [
                'code' => $code,
                'tagger_id' => $tagger->id,
                'tagger_type' => get_class($tagger)
            ]);
        });
    }

    /** @test */
    public function tag_has_taggables_pivot()
    {
        $tag = factory(Tag::class)->create();
        $group = factory(Group::class)->create();
        $area = factory(Area::class)->create();
        $campaign = factory(Campaign::class)->create();
        
        $this->assertEquals($tag->groups()->count(), 0);
        $this->assertEquals($tag->areas()->count(), 0);
        $this->assertEquals($tag->campaigns()->count(), 0);

        $tag->setGroup($group);
        $tag->setArea($area);
        $tag->setCampaign($campaign);

        $this->assertEquals($tag->groups()->count(), 1);
        $this->assertEquals($tag->areas()->count(), 1);
        $this->assertEquals($tag->campaigns()->count(), 1);

        $this->assertEquals($tag->groups()->first()->name, $group->name);
        $this->assertEquals($tag->areas()->first()->name, $area->name);
        $this->assertEquals($tag->campaigns()->first()->name, $campaign->name);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $group->id,
            'taggable_type' => get_class($group),
        ]);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $area->id,
            'taggable_type' => get_class($area),
        ]);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $campaign->id,
            'taggable_type' => get_class($campaign),
        ]);
    }
}
