<?php

namespace App\Missive\Domain\Validators;

use App\Missive\Domain\Exceptions\CreateGlobeRedirectValidationException;
use League\Tactician\Middleware;
use Validator;

class CreateContactFromGlobeRedirectValidator implements Middleware
{
    protected $rules = [
             'access_token' => 'required',
        'subscriber_number' => 'required',
    ];

    public function execute($command, callable $next)
    {
        $validator = Validator::make((array) $command, $this->rules);

        if ($validator->fails()) {
            throw new CreateGlobeRedirectValidationException($command, $validator);
        }

        return $next($command);
    }

}