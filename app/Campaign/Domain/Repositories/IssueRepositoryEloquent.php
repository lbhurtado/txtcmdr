<?php

namespace App\Campaign\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Repositories\IssueRepository;
use App\Campaign\Domain\Models\Issue;
use App\Campaign\Domain\Validators\IssueValidator;

/**
 * Class IssueRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class IssueRepositoryEloquent extends BaseRepository implements IssueRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Issue::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return IssueValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
