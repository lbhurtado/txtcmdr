<?php

namespace App\Campaign\Domain\Classes;

use Opis\String\UnicodeString as wstring;
use App\Campaign\Domain\Repositories\AlertRepository;

class AlertCommand extends Command
{
	const DEFAULT_CMD = '!';

    protected $alerts;

    public function __construct(AlertRepository $alerts)
    {
        $this->alerts = $alerts;
    }

    protected function go()
    {
        $names = implode($this->alerts->pluck('name')->toArray(), '|');
        $ids = implode($this->alerts->pluck('id')->toArray(), '|');

        $this->LST = wstring::from($names)->append('||')->append($ids);

        return $this;
    }

}
