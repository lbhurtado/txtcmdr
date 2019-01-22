<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\GroupTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GroupPresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class GroupPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GroupTransformer();
    }
}
