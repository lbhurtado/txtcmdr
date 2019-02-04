<?php

namespace App\Campaign\Domain\Traits;

use App\Campaign\Domain\Models\Checkin;
use App\Campaign\Domain\Classes\LatestCheckin;

trait HasLocation
{
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function checkin(...$coordinates)
    {
        $coordinates = array_flatten($coordinates);
        $longitude = $coordinates[0];
        $latitude = $coordinates[1];

        $checkin = $this->checkins()->create(compact('longitude', 'latitude'));

        return $checkin;
    }

    public function latestCheckin()
    {
        return $this->hasMany(LatestCheckin::class);
    }
}
