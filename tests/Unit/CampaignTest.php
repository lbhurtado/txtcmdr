<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Campaign\Domain\Repositories\CampaignRepository;

class CampaignTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function campaign_has_name_and_message()
    {
        tap(app(CampaignRepository::class), function ($campaigns) {
        	$name = $this->faker->name;
        	$message = $this->faker->sentence;
        	$campaign = $campaigns->create(compact('name', 'message'));
        	$this->assertEquals($name, $campaign->name);
        	$this->assertEquals($message, $campaign->message);	
        });
    }
}
