<?php

namespace App\Campaign\Domain\Classes\Collections;

class PollPrecincts extends PollArea
{
    public function getSelectField1()
    {
        return $field1 = 'concat_ws(", ", precincts.name, towns.name) as area';
    }

    public function getCategoryIds()
    {
        return [1,2,3];
    }

    public function getGroupByField1()
    {
        return 'precincts.id';
    }

    public function getOrderByField1()
    {
        return 'precincts.id';
    }
}