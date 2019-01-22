<?php

use App\Missive\Jobs\UpdateContact;

$txtcmdr = resolve('txtcmdr');

$txtcmdr->register('@{area}', function (string $path, array $values) {
	\Log::info("area = {$values['area']}");
});

$keywords = getKeywords();

$txtcmdr->register("{{$keywords}} {name}", function (string $path, array $values) use ($txtcmdr) {
	$mobile = $txtcmdr->getSMS()->from;
	UpdateContact::dispatch($mobile, $values['name']);
	\Log::info($values);
});

function getKeywords()
{
	return "keyword=abc|def";
}