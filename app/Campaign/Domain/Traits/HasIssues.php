<?php

namespace App\Campaign\Domain\Traits;

use App\Campaign\Domain\Models\Issue;
use App\Campaign\Domain\Models\AreaIssue as Pivot;

trait HasIssues
{
    public function issues()
    {
        return $this->belongsToMany(Issue::class)
            ->withPivot('qty', 'contact_id')
            ->using(Pivot::class)
            ->withTimestamps();
    }

    public function addIssue(Issue $issue, Pivot $pivot)
    {
        return $this->issues()->attach($issue, $pivot->getAttributes());
    }

    public function updateIssue(Issue $issue, Pivot $pivot)
    {
        return $this->issues()->updateExistingPivot($issue, $pivot->getAttributes());
    }
}
