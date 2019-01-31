<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderTag implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    protected $code;

    protected $originalCode;
     
    public function __construct(Contact $commander, $code, $originalCode = null)
    {
        $this->commander = $commander;
        $this->code = $code;
        $this->originalCode = $originalCode ?? $code;
    }

    public function handle()
    {
        tap($this->commander->syncTag($this->code), function ($tag) {
            $tag->originalCode = $this->originalCode;
        })->save();
    }
}
