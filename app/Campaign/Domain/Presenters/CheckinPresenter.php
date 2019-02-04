<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\CheckinTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CheckinPresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class CheckinPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CheckinTransformer();
    }
}
