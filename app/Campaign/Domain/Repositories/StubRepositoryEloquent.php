<?php

namespace App\Campaign\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Repositories\StubRepository;
use App\Campaign\Domain\Models\Stub;
use App\Campaign\Domain\Validators\StubValidator;

/**
 * Class StubRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class StubRepositoryEloquent extends BaseRepository implements StubRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Stub::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return StubValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
