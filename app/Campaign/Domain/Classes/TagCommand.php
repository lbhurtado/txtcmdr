<?php

namespace App\Campaign\Domain\Classes;

use App\Campaign\Domain\Repositories\AreaRepository;
use App\Campaign\Domain\Repositories\GroupRepository;
use App\Campaign\Domain\Repositories\CampaignRepository;

class TagCommand extends Command
{
	const DEFAULT_CMD = 'TAG';

	public $AREAS;

	public $GROUPS;

	protected $campaigns;

	protected $areaRepository;

    protected $groupRepository;

	public function __construct(CampaignRepository $campaigns, AreaRepository $areaRepository, GroupRepository $groupRepository)
	{
		$this->campaigns = $campaigns;

		$this->areaRepository = $areaRepository;

		$this->groupRepository = $groupRepository;
	}

	protected function go()
	{
	    $this->populateCampaigns()->populateAreas();

	    return $this;
	}

	protected function populateCampaigns()
    {
        $names = implode($this->campaigns->all()->sortByDesc('name')->pluck('name')->toArray(), '|');
        $ids = implode($this->campaigns->all()->sortByDesc('id')->pluck('id')->toArray(), '|');

        $this->LST = string($names)->concat('|')->concat($ids);

        return $this;
    }

	protected function populateAreas()
    {
        $names = implode($this->areaRepository->all()->sortByDesc('name')->pluck('name')->toArray(), '|');
        $ids = implode($this->areaRepository->all()->sortByDesc('id')->pluck('id')->toArray(), '|');

        $this->AREAS = string($names)->concat('|')->concat($ids);

        return $this;
    }

    protected function populateGroups()
    {
        $names = implode($this->groupRepository->all()->sortByDesc('name')->pluck('name')->toArray(), '|');
        $ids = implode($this->groupRepository->all()->sortByDesc('id')->pluck('id')->toArray(), '|');

        $this->GROUPS = string($names)->concat('|')->concat($ids);

        return $this;
    }
}
