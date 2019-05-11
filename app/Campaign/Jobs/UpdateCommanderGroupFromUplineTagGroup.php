<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Campaign\Domain\Models\Group;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderGroupFromUplineTagGroup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $commander;

    public $group;

    public function __construct(Contact $commander, Group $group)
    {
        $this->commander = $commander;
        $this->group = $group;
        $this->onQueue('sms');
    }

    public function handle()
    {
        $this->commander->syncGroups($this->group);
    }
}
