<?php

namespace Test;

use Nette,
	Tester,
	Tester\Assert,
	Goodreads\Goodreads;

$gr = require __DIR__ . '/../bootstrap.php';

$r = $gr->user->show(['username' => 'mikulas']);
