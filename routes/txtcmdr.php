<?php

$txtcmdr = resolve('txtcmdr');

$txtcmdr->register('@{area}', function (string $path, array $values) {
	\Log::info("area = {$values['area']}");
});

$regex = "keyword=abc|def";
$txtcmdr->register("{{$regex}} {name}", function (string $path, array $values) {
	\Log::info($values);
});
