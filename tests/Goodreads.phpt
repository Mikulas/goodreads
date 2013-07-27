<?php

namespace Test;

use Nette,
	Tester,
	Tester\Assert,
	Goodreads\Goodreads;

require __DIR__ . '/bootstrap.php';

// without credentials
Assert::exception(function() {
	Assert::error(function() {
		new Goodreads();
	}, E_WARNING);
}, 'Goodreads\InvalidSetupException');
Assert::exception(function() {
	new Goodreads(NULL);
}, 'Goodreads\InvalidSetupException');
Assert::exception(function() {
	new Goodreads('');
}, 'Goodreads\InvalidSetupException');

// with invalid credentials
Assert::error(function() {
	new Goodreads('invalid', str_repeat('a', 43));
}, E_USER_NOTICE);

Assert::error(function() {
	new Goodreads(str_repeat('a', 20), 'invalid');
}, E_USER_NOTICE);

// with valid credentials
new Goodreads('b1eQdQi14rjRJBqp1cbQ', 'MzqL7qQ6aF3OtGQFRZV05vxrZTGuOJV1ry23QSxJ48I');
