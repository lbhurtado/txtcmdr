<?php

namespace App\Campaign\Domain\Models\Inheritors;

//use Tightenco\Parental\HasParent;
use App\Campaign\Domain\Models\Area;

class District extends Area
{
//    use HasParent;
    protected static $singleTableType = 'district';

    protected static $persisted = ['_lft', '_rgt', 'parent_id'];

    public function towns()
    {
        return $this->children();
    }
}
