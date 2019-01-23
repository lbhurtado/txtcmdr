<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\AreaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AreaPresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class AreaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AreaTransformer();
    }
}
