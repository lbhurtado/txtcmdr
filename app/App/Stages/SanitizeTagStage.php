<?php

namespace App\App\Stages;

use App\Campaign\Domain\Repositories\TagRepository;

class SanitizeTagStage extends BaseStage
{
    protected $input_code;

    protected function enabled()
    {
        return $this->input_code = trim(array_get($this->getParameters(), 'code'));
    }

    public function execute()
    {
        $array = array_filter(explode(' ', $this->input_code));

        $code = '';
        while ($word = array_shift($array)) {
            $code = trim(string($code)->concat(' ')->concat($word));

            if ($tag = $this->getSanitizedTag($code)) {
                array_set($this->parameters, 'models.tag', $tag);
                array_set($this->parameters, 'handle', implode(' ', $array));

                return;
            }
        }

        $this->halt();
    }

    protected function getSanitizedTag($input)
    {
        return
            optional(app(TagRepository::class)->search($input), function ($hits) {
                return ($hits->count() == 1) ? $hits->first() : null;
            });
    }
}