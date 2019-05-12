<?php

namespace App\Campaign\Domain\Repositories;

use App\Campaign\Domain\Models\Issue;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
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

    public function search($query = '', $callback = null)
    {
        return Issue::search($query, $callback);
    }

    public function getSanitizedModel($input)
    {
        return
            $this->findByField('code', $input)->first() //great for testing
            ??
            optional($this->search($input), function ($hits) {
                return ($hits->count() == 1) ? $hits->first() : null;
            });
    }
}
