<?php

namespace App\Campaign\Domain\Classes;

use Opis\String\UnicodeString as wstring;
use App\Campaign\Domain\Repositories\AreaRepository;
use App\Campaign\Domain\Repositories\CampaignRepository;

class TagCommand extends Command
{
	const DEFAULT_CMD = 'TAG';

	public $AREAS;

	protected $campaigns;

	protected $areaRepository;

	public function __construct(CampaignRepository $campaigns, AreaRepository $areaRepository)
	{
		$this->campaigns = $campaigns;

		$this->areaRepository = $areaRepository;
	}

	protected function go()
	{
	    $this->populateCampaigns()->populateAreas();

	    return $this;
	}

	protected function populateCampaigns()
    {
        $names = implode($this->campaigns->pluck('name')->toArray(), '|');
        $ids = implode($this->campaigns->pluck('id')->toArray(), '|');

        $this->LST = string($names)->concat('||')->concat($ids);

        return $this;
    }

	protected function populateAreas()
    {
        $names = implode($this->areaRepository->pluck('name')->toArray(), '|');
        $ids = implode($this->areaRepository->pluck('id')->toArray(), '|');

        $this->AREAS = string($names)->concat('||')->concat($ids);

        return $this;
    }
}