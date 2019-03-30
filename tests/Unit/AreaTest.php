<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Campaign\Domain\Repositories\AreaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AreaTest extends TestCase
{
    use DatabaseTransactions;

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
