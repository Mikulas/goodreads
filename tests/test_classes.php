<?php

namespace Test;

use Goodreads\Classes\ApiClass;

class TestApiClass extends ApiClass
{
	/**
	 * @url /base
	 */
	protected function methodTestNoArgs() {}

	/**
	 * @url /base/<id>
	 */
	protected function methodTestId() {}
}

class Case1 extends ApiClass
{
	/**
	 * @url /base/<id>?foo=<bar>
	 */
	protected function methodTest() {}
}

class Case2 extends ApiClass
{
	/**
	 * @url /base/<-id>?foo=<bar?>
	 */
	protected function methodTest() {}
}

class Case3 extends ApiClass
{
	/**
	 * @url /base/>id<?foo=>bar<
	 */
	protected function methodTest() {}
}

class Case4 extends ApiClass
{
	/**
	 * @url <id><id>
	 */
	protected function methodTest() {}
}

class Case5 extends ApiClass
{
	/**
	 * @url /method/<id>
	 * @param string $format
	 */
	protected function methodTest() {}
}

class Case6 extends ApiClass
{
	/**
	 * @url /method
	 * @param string $foo {optional}
	 * @param string $bar {optional baz}
	 */
	protected function methodTest() {}
}

class Case7 extends ApiClass
{
	/**
	 * @url /method/<id>
	 * @param string $format
	 * @param int $user_id
	 * @param int $rating
	 */
	protected function methodTest() {}
}

class Case8 extends ApiClass
{
	protected function methodTest() {}
}
