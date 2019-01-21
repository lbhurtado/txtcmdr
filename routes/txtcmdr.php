<?php

$txtcmdr = resolve('txtcmdr');

$txtcmdr->register('@{area}', function (string $path, array $values) {
	\Log::info("area = {$values['area']}");
});

$txtcmdr->register('{keyword} {name}', function (string $path, array $values) {
	\Log::info($values);
});
