<?php

namespace App\Campaign\Domain\Classes\Collections;

class PollClusters extends PollArea
{
    public function getSelectField1()
    {
        return 'concat_ws(", ", group_concat(distinct precincts.name separator " "), towns.name) as area';
    }

    public function getCategoryIds()
    {
        return [1,2,3];
    }

    public function getGroupByField1()
    {
        return 'clusters.id';
    }

    public function getOrderByField1()
    {
        return 'clusters.id';
    }
}