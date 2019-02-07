<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\QueryException;
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

        $this->onQueue('sms');
    }

    public function handle()
    {
        try
        {
            $this->commander->syncTag($this->code);
        }
        catch (QueryException $e) {
            $dash = "-";
            $this->commander->syncTag(string($this->code)->concat($dash)->concat($this->commander->id));
        }
    }
}
