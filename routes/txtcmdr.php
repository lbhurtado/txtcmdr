<?php

use App\App\Services\Router;

$txtcmdr = resolve('txtcmdr');

$txtcmdr->register('test', function () {
	\Log::info('It Works, yeah, yeah yo!');
    // return "Hi";
});

$txtcmdr->register('call/mom', function () {
    return "Dial 0123456789";
});

// Invokig

// $txtcmdr->execute('test'); //> Hi
echo $txtcmdr->execute('call/mom'); //> Dial 0123456789