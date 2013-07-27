<?php

namespace Test;

use Nette,
	Nette\Reflection\ClassType,
	Tester,
	Tester\Assert,
	Goodreads\Goodreads;

$gr = require __DIR__ . '/bootstrap.php';

$method = Access($gr->user, 'request');

$response = $method->call($gr->getBaseUrl() . '/author/show.xml?key=' . $gr->getKey(), 'GET');
var_dump($response);
Assert::same("<error>author not found</error>\n", $response);
