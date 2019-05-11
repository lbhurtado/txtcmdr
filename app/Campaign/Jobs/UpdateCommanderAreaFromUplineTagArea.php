<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderAreaFromUplineTagArea implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $commander;

    public $area;

    public function __construct(Contact $commander, $area)
    {
        $this->commander = $commander;
        $this->area = $area;
        $this->onQueue('sms');
    }

    public function handle()
    {
        $this->commander->syncAreas($this->area);
    }
}
