<?php

namespace Goodreads;

/**
 * @property-read Goodreads\Classes\User $user
 */
class Goodreads
{

	const BASE_URL = 'http://www.goodreads.com';

	/** @var string */
	private $key;

	/** @var string */
	private $secret;

	/** @var Goodreads\ClassGetter */
	private $classGetter;

	/**
	 * @param string $key
	 * @param NULL|string $secret
	 */
	public function __construct($key, $secret = NULL)
	{
		if (!isset($key) || !trim($key)) {
			throw new InvalidSetupException('Provide application key, empty string given.');
		}
		if (!$this->validateKey($key)) {
			trigger_error('Invalid key given, expecting 20 alphanumeric chars, ' . strLen($key) . ' given.', E_USER_NOTICE);
		}
		$this->key = $key;

		if ($secret) {
			if (!$this->validateSecret($secret)) {
				trigger_error('Invalid secret given, expecting 43 alphanumeric chars, ' . strLen($secret) . ' given.', E_USER_NOTICE);
			}
			$this->secret = $secret;
		}
		$this->classGetter = new ClassGetter;
	}

	private function validateKey($key)
	{
		return preg_match('~^[a-zA-Z0-9]{20}$~', $key);
	}

	private function validateSecret($secret)
	{
		return preg_match('~^[a-zA-Z0-9]{43}$~', $secret);
	}

	public function __get($class)
	{
		return $this->classGetter->get($this, $class);
	}

	public function getBaseUrl()
	{
		return self::BASE_URL;
	}

	public function getKey()
	{
		return $this->key;
	}

}

class AuthenticationException extends \RuntimeException {}
class InvalidSetupException extends \BadMethodCallException {}
class InvalidApiGetterException extends \DomainException {}
class InvalidMethodDefinitionException extends \LogicException {}
class InvalidMethodCallException extends \BadMethodCallException {}
class InvalidMethodUrlException extends \InvalidArgumentException {}
