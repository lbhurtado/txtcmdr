<?php

namespace Tests;

use Tests\TestCase;
use App\Missive\Domain\Models\Contact;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TextCommanderCase extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $commander;

    protected $destination;

    function setup()
    {
        parent::setUp();

        $this->commander = factory(Contact::class)->create(['mobile' => $this->generateMobile()]);
        $this->destination = $this->generateMobile();
        $this->endpoint = $this->getEndpoint();
    }
}
