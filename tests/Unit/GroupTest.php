<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Campaign\Domain\Repositories\GroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroupTest extends TestCase
{
    use DatabaseTransactions;

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
