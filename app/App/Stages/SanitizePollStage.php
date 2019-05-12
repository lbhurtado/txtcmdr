<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;

class SanitizePollStage extends BaseStage
{
    protected $poll_text;

    protected function enabled()
    {
        return $this->poll_text = trim(Arr::get($this->getParameters(), 'poll'));
    }

    public function execute()
    {
        $poll_array = $this->getSanitizedPollArray();

        Arr::set($this->parameters, 'poll_array', $poll_array);
    }

    protected function getSanitizedPollArray()
    {
        return process_word_number_sequence($this->poll_text);
    }
}
