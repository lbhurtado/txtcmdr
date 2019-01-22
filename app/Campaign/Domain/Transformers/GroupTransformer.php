<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Group;

/**
 * Class GroupTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class GroupTransformer extends TransformerAbstract
{
    /**
     * Transform the Group entity.
     *
     * @param \App\Campaign\Domain\Models\Group $model
     *
     * @return array
     */
    public function transform(Group $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
