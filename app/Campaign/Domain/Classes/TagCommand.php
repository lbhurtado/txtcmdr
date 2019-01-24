<?php

namespace App\Campaign\Domain\Classes;

use Opis\String\UnicodeString as wstring;
use App\Campaign\Domain\Repositories\CampaignRepository;

class TagCommand extends Command
{
	const DEFAULT_CMD = '#';

	protected $campaigns;

	public function __construct(CampaignRepository $campaigns)
	{
		$this->campaigns = $campaigns;
	}

	protected function go()
	{
		$names = implode($this->campaigns->pluck('name')->toArray(), '|');
		$ids = implode($this->campaigns->pluck('id')->toArray(), '|');

		$this->LST = wstring::from($names)->append('||')->append($ids);

		return $this;
	}
}