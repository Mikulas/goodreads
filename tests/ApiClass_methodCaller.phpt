<?php

namespace Test;

use Nette,
	Tester,
	Tester\Assert,
	Goodreads\Goodreads;

$gr = require __DIR__ . '/bootstrap.php';

$class = new TestApiClass($gr);

$class->testNoArgs();

$class->testId(['id' => 1]);

Assert::exception(function() use ($class) {
	$class->testId();
}, 'Goodreads\InvalidMethodCallException');

Assert::exception(function() use ($class) {
	$class->testId(1);
}, 'Goodreads\InvalidMethodCallException');

Assert::exception(function() use ($class) {
	$class->bogus();
}, 'Goodreads\InvalidMethodCallException');


$class = new Case8($gr);
Assert::exception(function() use ($class) {
	$class->test();
}, 'Goodreads\InvalidMethodDefinitionException');
