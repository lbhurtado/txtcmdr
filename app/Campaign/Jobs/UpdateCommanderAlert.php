<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Campaign\Domain\Models\Alert;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    protected $alert;

    public function __construct(Contact $commander, Alert $alert)
    {
        $this->commander = $commander;
        $this->alert = $alert;
    }

    public function handle()
    {
        $this->commander->alerts()->save($this->alert);
    }
}
