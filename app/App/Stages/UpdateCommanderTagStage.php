<?php

namespace App\App\Stages;

use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Domain\Repositories\{AreaRepository, GroupRepository};

class UpdateCommanderTagStage extends BaseStage
{
    public function execute()
    {
        $this->dispatch(new UpdateCommanderTag($this->getCommander(), $this->getCode()));
    }

    protected function getCode()
    {
        $space = " ";
        
        return string($this->tag())->concat($space)->concat($this->context())->toUpper();
    }

    protected function tag()
    {
        return array_get($this->getParameters(), 'tag') ?? config('txtcmdr.tag');
    }

    protected function context()
    {
//        $repositories = [
//            'area' => AreaRepository::class,
//            'group' => GroupRepository::class
//        ];
//
        $field = array_get($this->getParameters(), 'field', 'area');
//
//        $context = trim(array_get($this->getParameters(), 'context'));
//
//        $model =  app($repositories[$field])->findByField('name',  $context)->first();

        $model = array_get($this->parameters, 'models')[$field];
        return $model->alias ?? $model->name;

//        return trim(array_get($this->getParameters(), 'area'));
//        return array_get($this->getParameters(), 'context');
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
