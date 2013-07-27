<?php

namespace Test;

use Nette,
	Tester,
	Tester\Assert,
	Goodreads\Goodreads;

$gr = require __DIR__ . '/bootstrap.php';

Assert::type('Goodreads\Classes\User', $gr->user);

Assert::exception(function() use ($gr) {
	$gr->bogus;
}, 'Goodreads\InvalidApiGetterException');
