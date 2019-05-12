<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Campaign\Domain\Models\Area;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderIssues implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $commander;

    public $poll_array;

    public $area;

    public function __construct(Contact $commander, $poll_array = [], Area $area = null)
    {
        $this->commander = $commander;
        $this->poll_array = $poll_array;
        $this->area = $area;

        $this->onQueue('sms');
    }

    public function handle()
    {
        foreach ($this->poll_array as $word => $number) {
            $this->commander->poll($word, $number, $this->area);
        }
    }
}
