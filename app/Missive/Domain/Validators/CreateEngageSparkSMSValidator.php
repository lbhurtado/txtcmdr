<?php
/**
 * Created by PhpStorm.
 * User: aph
 * Date: 2019-02-09
 * Time: 17:37
 */

namespace App\Missive\Domain\Validators;

use App\Missive\Domain\Exceptions\CreateSMSValidationException;
use League\Tactician\Middleware;
use Validator;

class CreateEngageSparkSMSValidator implements Middleware
{
    protected $rules = [
        'secret' => 'required',
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
