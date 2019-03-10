<?php

namespace App\Campaign\Domain\Models\Inheritors;

//use Tightenco\Parental\HasParent;
use App\Campaign\Domain\Models\Area;

class Town extends Area
{
//    use HasParent;
    protected static $singleTableType = 'town';

    protected static $persisted = ['_lft', '_rgt', 'parent_id'];
}
