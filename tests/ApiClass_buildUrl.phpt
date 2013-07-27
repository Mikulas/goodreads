<?php

namespace Test;

use Nette,
	Nette\Reflection\ClassType,
	Tester,
	Tester\Assert,
	Goodreads\Goodreads;

$gr = require __DIR__ . '/bootstrap.php';

$method = Access($gr->user, 'buildUrl');

Assert::same($gr->getBaseUrl() . '/test.xml', $method->call('/test.xml', []));

Assert::exception(function() use ($method) {
	$method->call('/test/<id>', []);	
}, 'Goodreads\\InvalidMethodDefinitionException');

Assert::same($gr->getBaseUrl() . '123', $method->call('<a><b><c>', [
	'a' => 1,
	'b' => 2,
	'c' => 3,
]));

Assert::same($gr->getBaseUrl() . '123?foo=bar&baz=qaz', $method->call('<id>', [
	'id' => 123,
	'foo' => 'bar',
	'baz' => 'qaz',
]));
