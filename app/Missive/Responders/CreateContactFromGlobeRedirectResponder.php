<?php

namespace App\Missive\Responders;

use League\Tactician\Middleware;
use App\Missive\Domain\Resources\CreateContactFromGlobeRedirectResource;

class CreateContactFromGlobeRedirectResponder implements Middleware
{
    public function execute($command, callable $next)
    {        
        $retval = $next($command);
        
        return (new CreateContactFromGlobeRedirectResource($command))
            ->response()
            ->setStatusCode(200) //required by Globe Connect
            ;
    }
}