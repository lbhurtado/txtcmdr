<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\LeadTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LeadPresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class LeadPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LeadTransformer();
    }
}
