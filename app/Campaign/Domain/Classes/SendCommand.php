<?php

namespace App\Campaign\Domain\Classes;

//use App\Campaign\Domain\Repositories\{AreaRepository, GroupRepository};

class SendCommand extends Command
{
	const DEFAULT_CMD = ':';

//    protected $areaRepository;
//
//    protected $groupRepository;
//
//	public function __construct(AreaRepository $areaRepository, GroupRepository $groupRepository)
//	{
//        $this->areaRepository = $areaRepository;
//        $this->groupRepository = $groupRepository;
//	}

	protected function go()
	{
//	    $this->populateAreas()->populateGroups();
//
//        $this->LST = string($this->AREAS)->concat('|')->concat($this->GROUPS); //remove this in the future

        return $this;
	}

//    protected function populateAreas()
//    {
//        $names = implode($this->areaRepository->all()->sortByDesc('name')->pluck('name')->toArray(), '|');
//        $ids = implode($this->areaRepository->all()->sortByDesc('id')->pluck('id')->toArray(), '|');
//
//        $this->AREAS = string($names)->concat('|')->concat($ids);
//
//        return $this;
//    }
//
//    protected function populateGroups()
//    {
//        $names = implode($this->groupRepository->all()->sortByDesc('name')->pluck('name')->toArray(), '|');
//        $ids = implode($this->groupRepository->all()->sortByDesc('id')->pluck('id')->toArray(), '|');
//
//        $this->GROUPS = string($names)->concat('|')->concat($ids);
//
//        return $this;
//    }
}