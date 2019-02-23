<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Issue;

/**
 * Class IssueTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class IssueTransformer extends TransformerAbstract
{
    /**
     * Transform the Issue entity.
     *
     * @param \App\Campaign\Domain\Models\Issue $model
     *
     * @return array
     */
    public function transform(Issue $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
