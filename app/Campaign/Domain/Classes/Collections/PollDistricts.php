<?php

namespace App\Campaign\Domain\Classes\Collections;

class PollDistricts extends PollArea
{
    public function getSelectField1()
    {
        return $field1 = 'concat_ws(", ", districts.name) as area';
    }

    public function getCategoryIds()
    {
        return [1, 2];
    }

    public function getGroupByField1()
    {
        return 'districts.id';
    }

    public function getOrderByField1()
    {
        return 'districts.id';
    }
}
