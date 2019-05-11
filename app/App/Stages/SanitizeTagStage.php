<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Domain\Repositories\TagRepository;

class SanitizeTagStage extends BaseStage
{
    protected $input_code;

    protected function enabled()
    {
        return $this->input_code = trim(Arr::get($this->getParameters(), 'code'));
    }

    public function execute()
    {
        $array = array_filter(explode(' ', $this->input_code));

        $code = '';
        while ($word = array_shift($array)) {
            $code = trim(string($code)->concat(' ')->concat($word));
            if ($tag = $this->getSanitizedTag($code)) {

                Arr::set($this->parameters, 'models.tag', $tag);
                Arr::set($this->parameters, 'handle', implode(' ', $array));

                return;
            }
        }

        $this->halt();
    }

    protected function getSanitizedTag($input)
    {
        return app(TagRepository::class)->getSanitizedModel($input);
    }
}
