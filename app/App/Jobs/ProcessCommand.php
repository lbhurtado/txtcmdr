<?php

namespace App\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function handle()
    {
        tap(app()->make('txtcmdr'), function ($txtcmdr) {
            $txtcmdr->execute($this->command);
        });
    }
}
