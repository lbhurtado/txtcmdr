<?php

namespace App\Campaign\Domain\Repositories;

use App\Campaign\Domain\Models\Group;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Validators\GroupValidator;
use App\Campaign\Domain\Repositories\GroupRepository;

/**
 * Class GroupRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class GroupRepositoryEloquent extends BaseRepository implements GroupRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Group::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GroupValidator::class;
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
        return Group::search($query, $callback);
    }

    public function getSanitizedModel($input)
    {
        return
            optional($this->search($input), function ($hits) {
                return ($hits->count() == 1) ? $hits->first() : null;
            });
    }
}
