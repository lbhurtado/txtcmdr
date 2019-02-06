<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Domain\Classes\{Command, CommandKey};

class UpdateCommanderTagStage extends BaseStage
{
//    protected function enabled()
//    {
//        return $this->getCommander()->tags()->count() == 0;
//    }

    public function execute()
    {
        $this->dispatch(new UpdateCommanderTag($this->getCommander(), $this->getCode()));
    }

    protected function getCode()
    {
        $space = " ";
        
        return string($this->getTag())->concat($space)->concat($this->getSuffix())->toUpper();
    }
//    protected function getCode()
//    {
//        $command = array_get($this->getParameters(), 'command');
//
//        return Command::using(CommandKey::TAG)->CMD == $command
//                ? $this->getTag()
//                : $this->getUplineTag() . $this->getRandomSuffix();
//                ;
//    }

    protected function getTag()
    {
        return array_get($this->getParameters(), 'tag') ?? config('txtcmdr.tag');
    }

    protected function getSuffix()
    {
        return array_get($this->getParameters(), 'context');
    }
//
//    protected function getUplineTag()
//    {
//        return optional($this->getCommander()->upline, function ($upline) {
//            return optional($upline->tags()->first(), function ($tag) {
//                return $tag->originalCode;
//            });
//        });
//    }
//    protected function getRandomSuffix()
//    {
//        //extend this -> floor ceiling from config
//
//        return rand(100, 999);
//    }
}
