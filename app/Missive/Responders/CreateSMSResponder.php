<?php

namespace App\Missive\Responders;

use League\Tactician\Middleware;
use App\Missive\Domain\Resources\CreateSMSResource;

class CreateSMSResponder implements Middleware
{
    public function execute($command, callable $next)
    {        
        $retval = $next($command);

        // \Log::info("CreateSMSResponder::execute");
        
        return (new CreateSMSResource($command))
            ->response()
            // ->setStatusCode(422)
            ;
    }
}