<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\CampaignTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CampaignPresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class CampaignPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CampaignTransformer();
    }
}
