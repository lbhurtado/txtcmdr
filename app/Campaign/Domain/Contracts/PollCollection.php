<?php

namespace App\Campaign\Domain\Contracts;


interface PollCollection
{
    public function getSelectField1();

    public function getCategoryIds();

    public function getGroupByField1();

    public function getOrderByField1();
}