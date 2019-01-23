<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Domain\Repositories\AreaRepository;

class AreaTest extends TestCase
{
	use RefreshDatabase, WithFaker;

    /** @test */
    public function area_has_name()
    {
        tap(app(AreaRepository::class), function ($areas) {
        	$name = $this->faker->name;
        	$area = $areas->create(compact('name'));
        	$this->assertEquals($name, $area->name);	
        });
    }
}
