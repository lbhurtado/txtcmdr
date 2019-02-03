<?php

namespace App\Campaign\Domain\Traits;

use App\Campaign\Domain\Models\Alert;

trait SendsAlert
{
    public function alerts()
    {
        return $this->belongsToMany(Alert::class)->withTimestamps();
    }

    public function latest_alerts()
    {
        return $this->belongsToMany(Alert::class, 'latest_alert_contact')->withTimestamps();
    }
}
