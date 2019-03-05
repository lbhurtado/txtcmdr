<?php

namespace App\Campaign\Domain\Classes\Collections;


class PollBarangays extends PollArea
{
    public function getSelectField1()
    {
        return $field1 = 'concat_ws(", ", barangays.name, towns.name) as area';
    }

    public function getCategoryIds()
    {
        return [1,2,3];
    }

    public function getGroupByField1()
    {
        return 'barangays.id';
    }

    public function getOrderByField1()
    {
        return 'barangays.id';
    }
}