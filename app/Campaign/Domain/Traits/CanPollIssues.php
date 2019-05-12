<?php

namespace App\Campaign\Domain\Traits;

use App\Campaign\Domain\Models\Area;
use Illuminate\Database\QueryException;
use App\Campaign\Domain\Models\AreaIssue;
use App\Campaign\Domain\Repositories\IssueRepository;

trait CanPollIssues
{
    public function poll($issue, $qty, Area $area = null)
    {
        optional($area ?? $this->areas()->first(), function ($area) use ($issue, $qty) {
            $pivot = AreaIssue::conjure($this, $qty);
            optional(app(IssueRepository::class)->getSanitizedModel($issue), function ($issue) use ($area, $pivot) {
                try {
                    $area->addIssue($issue, $pivot);
                }
                catch (QueryException $e) {
                    $area->updateIssue($issue, $pivot);
                }

            });
        });

        return $this;
    }
}
