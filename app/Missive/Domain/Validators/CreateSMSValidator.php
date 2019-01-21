<?php

namespace App\Missive\Domain\Validators;

use App\Missive\Domain\Exceptions\CreateSMSValidationException;
use League\Tactician\Middleware;
use Validator;

class CreateSMSValidator implements Middleware
{
    protected $rules = [
           'from' => 'required',
             'to' => 'required',
        'message' => 'string|max:500'
    ];

    public function execute($command, callable $next)
    {
        $validator = Validator::make((array) $command, $this->rules);

        if ($validator->fails()) {
            throw new CreateSMSValidationException($command, $validator);
        }

        return $next($command);
    }

}