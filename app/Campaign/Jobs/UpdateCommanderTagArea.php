<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Campaign\Domain\Models\Area;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderTagArea implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    protected $area;

    public function __construct(Contact $commander, Area $area)
    {
        $this->commander = $commander;
        $this->area = $area;

        $this->onQueue('sms');
    }

    public function handle()
    {
        $this->commander->tag->setArea($this->area, true);
    }
}
