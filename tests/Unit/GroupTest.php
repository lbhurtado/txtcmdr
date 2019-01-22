<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Domain\Repositories\GroupRepository;

class GroupTest extends TestCase
{
	use RefreshDatabase, WithFaker;

    /** @test */
    public function group_has_name()
    {
        tap(app(GroupRepository::class), function ($groups) {
        	$name = $this->faker->name;
        	$group = $groups->create(compact('name'));
        	$this->assertEquals($name, $group->name);	
        });
    }
}
