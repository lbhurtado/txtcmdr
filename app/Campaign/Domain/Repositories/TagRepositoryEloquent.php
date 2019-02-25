<?php

namespace App\Campaign\Domain\Repositories;

use App\Campaign\Domain\Models\Tag;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Validators\TagValidator;

/**
 * Class TagRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class TagRepositoryEloquent extends BaseRepository implements TagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TagValidator::class;
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
        return Tag::search($query, $callback);
    }

    public function getSanitizedModel($input)
    {
        return
            optional($this->search($input), function ($hits) {
                return ($hits->count() == 1) ? $hits->first() : null;
            });
    }
}
