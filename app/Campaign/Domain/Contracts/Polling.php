<?php

namespace App\Campaign\Domain\Contracts;

interface Polling
{
    public function poll($issue_code, $qty);
}
