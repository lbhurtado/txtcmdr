<?php

namespace App\Campaign\Domain\Contracts;

interface CanPoll
{
    public function poll($issue_code, $qty);
}
