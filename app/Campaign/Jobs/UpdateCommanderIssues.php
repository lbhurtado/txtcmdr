<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
//use App\Campaign\Domain\Models\Lead;
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

    public function __construct(Contact $commander, $poll_array = [])
    {
        $this->commander = $commander;
        $this->poll_array = $poll_array;

        $this->onQueue('sms');
    }

    public function handle()
    {
        foreach ($this->poll_array as $word => $number) {
            $this->commander->poll($word, $number);
        }
    }
}
