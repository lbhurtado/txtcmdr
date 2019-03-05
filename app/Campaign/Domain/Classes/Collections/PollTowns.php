<?php

namespace App\Campaign\Domain\Classes\Collections;


class PollTowns extends PollArea
{
    public function getSelectField1()
    {
        return $field1 = 'concat_ws(", ", towns.name) as area';
    }

    public function getCategoryIds()
    {
        return [1,2,3];
    }

    public function getGroupByField1()
    {
        return 'towns.id';
    }

    public function getOrderByField1()
    {
        return 'towns.id';
    }
}