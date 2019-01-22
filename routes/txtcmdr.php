<?php

use League\Pipeline\Pipeline;
use App\App\Stages\UpdateContactStage;

$txtcmdr = resolve('txtcmdr');

$txtcmdr->register('@{area}', function (string $path, array $values) {
	\Log::info("area = {$values['area']}");
});

$keywords = getKeywords();

$txtcmdr->register("{{$keywords}} {name}", function (string $path, array $attributes) {
	(new Pipeline)
	    ->pipe(new UpdateContactStage)
	    ->process($attributes)
	    ;
});

function getKeywords()
{
	return "keyword=abc|def";
}