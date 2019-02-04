<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Checkin;

/**
 * Class CheckinTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class CheckinTransformer extends TransformerAbstract
{
    /**
     * Transform the Checkin entity.
     *
     * @param \App\Campaign\Domain\Models\Checkin $model
     *
     * @return array
     */
    public function transform(Checkin $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
