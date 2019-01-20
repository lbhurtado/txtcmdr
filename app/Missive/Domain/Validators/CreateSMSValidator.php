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
        // 'message' => 'required'
    ];

    public function execute($command, callable $next)
    {
        \Log::info("CreateSMSValidator::execute");

        $validator = Validator::make((array) $command, $this->rules);
        if ($validator->fails()) {
            // throw new CommandValidationException($command, $validator);
            throw new CreateSMSValidationException("hello");
        }

        return $next($command);
    }

}