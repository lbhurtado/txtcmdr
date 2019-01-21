<?php

use App\Missive\Jobs\UpdateContact;

$txtcmdr = resolve('txtcmdr');

$txtcmdr->register('@{area}', function (string $path, array $values) {
	\Log::info("area = {$values['area']}");
});

$regex = "keyword=abc|def";
// $txtcmdr->register("{keyword=abc|def} {name}", function (string $path, array $values) use ($txtcmdr) {
$txtcmdr->register("{{$regex}} {name}", function (string $path, array $values) use ($txtcmdr) {
	$mobile = $txtcmdr->getMobile();
	UpdateContact::dispatch($mobile, $values['name']);
	\Log::info($values);
});
