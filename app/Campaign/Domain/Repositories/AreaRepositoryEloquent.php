<?php

namespace App\Campaign\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Repositories\AreaRepository;
use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Validators\AreaValidator;

/**
 * Class AreaRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class AreaRepositoryEloquent extends BaseRepository implements AreaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Area::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AreaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
