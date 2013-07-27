<?php

namespace Test;

use Nette,
	Nette\Reflection\ClassType,
	Tester,
	Tester\Assert,
	Goodreads\Goodreads;

$gr = require __DIR__ . '/bootstrap.php';

$method = Access($gr->user, 'parseParameters');


$case1 = (new ClassType('Test\\Case1'))->getMethod('methodTest');
Assert::same(['id' => NULL, 'bar' => NULL], $method->call($case1));

$case2 = (new ClassType('Test\\Case2'))->getMethod('methodTest');
Assert::same([], $method->call($case2));

$case3 = (new ClassType('Test\\Case3'))->getMethod('methodTest');
Assert::same([], $method->call($case3));

$case4 = (new ClassType('Test\\Case4'))->getMethod('methodTest');
Assert::exception(function() use ($method, $case4) {
	$method->call($case4);
}, 'Goodreads\\InvalidMethodUrlException');

$case5 = (new ClassType('Test\\Case5'))->getMethod('methodTest');
Assert::same(['id' => NULL, 'format' => NULL], $method->call($case5));

$case6 = (new ClassType('Test\\Case6'))->getMethod('methodTest');
Assert::same(['bar' => 'baz'], $method->call($case6));

$case7 = (new ClassType('Test\\Case7'))->getMethod('methodTest');
Assert::same(['id' => NULL, 'format' => NULL, 'user_id' => NULL, 'rating' => NULL], $method->call($case7));
