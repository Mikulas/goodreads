<?php

namespace Goodreads\Classes;

use Goodreads\InvalidMethodDefinitionException;
use Goodreads\InvalidMethodUrlException;
use Goodreads\InvalidMethodCallException;
use Goodreads\AuthenticationException;
use Goodreads\Goodreads;
use Goodreads\MethodCaller;
use Nette\Reflection\ClassType;
use ReflectionException;
use Nette\Utils\Strings as String;
use Nette\Reflection\Method;
use cURL\Request;

abstract class ApiClass
{

	/** @var Goodreads\Goodreads */	
	private $api;

	/**
	 * @param Goodreads $api [description]
	 */
	public function __construct(Goodreads $api)
	{
		$this->api = $api;
	}

	/**
	 * @return Goodreads
	 */
	final protected function getApi()
	{
		return $this->api;
	}

	/**
	 * @param string $method
	 * @param array $args
	 */
	final public function __call($method, $_args)
	{
		$nsMethod = 'method' . ucFirst($method);

		$ref = new ClassType($this);
		try {
			$mref = $ref->getMethod($nsMethod);

		} catch (ReflectionException $e) {
			$class = get_class($this);
			throw new InvalidMethodCallException("API class $class does not implement $method.", NULL, $e);
		}

		if (!$mref->hasAnnotation('url')) {
			throw new InvalidMethodDefinitionException("Method $method does not have url annotation.");
		}

		if (isset($_args[0]) && !is_array($_args[0])) {
			$class = get_class($this);
			throw new InvalidMethodCallException("API methods are called with an array of options.", NULL, $e);
		}
		$args = isset($_args[0]) ? $_args[0] : [];

		$params = $this->parseParameters($mref);
		$missing = [];
		foreach ($params as $param => $default) {
			if (!isset($args[$param]) && $default === NULL) {
				$missing[] = $param;
			}
		}

		if ($missing) {
			throw new InvalidMethodCallException("Missing required paramaters for $method: " . implode(', ', $missing));
		}

		foreach ($args as $p => $val) {
			$params[$p] = $val;
		}
		$params += [
			'key' => $this->api->getKey(),
		];

		$url = $this->buildUrl($mref->getAnnotation('url'), $params);
		$method = $mref->getAnnotation('method') ?: 'GET';

		list($content, $meta) = $this->request($url, $method);
		return $this->$nsMethod($content, (object) $meta);
	}

	/**
	 * @param Method $method
	 * @return array [key => defaultValue|NULL]
	 */
	private function parseParameters(Method $method)
	{
		$url = $method->getAnnotation('url');
		$params = [];
		foreach (String::matchAll($url, '~<(?P<param>\w+)>~') as $m) {
			$p = $m['param'];
			if (array_key_exists($p, $params)) {
				throw new InvalidMethodUrlException("Duplicate parameter $p in $url.");
			}
			$params[$p] = NULL;
		}

		$anns = $method->getAnnotations();
		if (isset($anns['param'])) {
			foreach ($anns['param'] as $p) {
				/**
				 * Match examples:
				 * int $variable
				 * bogus $aFooBar default
				 * @see http://php.net/manual/en/language.variables.basics.php
				 */
				$res = String::match($p, '~
					^\s*
					(?P<type>\w+) \s+
					\$(?P<name>[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)
					(\s+
						{
							(?P<optional>optional)
							(
								\s+
								(?P<default>\S+)
								\s*
							)?
						}
					)?
					\s*$
				~x');
				if (!$res || !$res['type']) {
					throw new InvalidMethodUrlException("$method has invalid property declarations.");
				}

				$p = $res['name'];
				if (array_key_exists($p, $params)) {
					var_dump($p, $params);
					throw new InvalidMethodUrlException("Duplicate parameter $p in $url.");
				}

				if (isset($res['optional'])) {
					if (isset($res['default'])) {
						$params[$p] = $res['default'];
					}

				} else {
					$params[$p] = NULL;
				}
			}
		}

		return $params;
	}

	/**
	 * Replaces placeholders and appends parameters
	 * @param string $url
	 * @param array $params
	 * @return
	 */
	private function buildUrl($url, $params)
	{
		$url = String::replace($url, '~<(?P<param>\w+)>~', function($res) use ($url, & $params) {
			$p = $res['param'];
			var_dump($params, $p);
			if (!isset($params[$p])) {
				throw new InvalidMethodDefinitionException("Method with url $url does not have parameters defined properly.");
			}

			$val = $params[$p];
			unset($params[$p]);
			return $val;
		});

		if ($params) {
			$url .= (strpos($url, '?') === FALSE ? '?' : "&") . http_build_query($params);
		}

		return $this->api->getBaseUrl() . $url;
	}

	/**
	 * @param string $url
	 * @return cURL\Response
	 */
	private function request($url, $method)
	{
		echo "$url\n";
		$request = new Request($url);
		$request->getOptions()
			->set(CURLOPT_CUSTOMREQUEST, $method)
			->set(CURLOPT_RETURNTRANSFER, true);
		$response = $request->send();

		if ($response->hasError()) {
			$error = $response->getError();
			dump($error);
		}

		return [$response->getContent(), $response->getInfo()];
	}

}
