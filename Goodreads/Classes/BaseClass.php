<?php

namespace Goodreads\Classes;

use SimpleXMLElement;
use Goodreads\InvalidMethodCallException;

abstract class BaseClass extends ApiClass
{

	/**
	 * @param string $str xml
	 * @return SimpleXMLElement
	 */
	private function parseXml($str)
	{
		try {
			return @new SimpleXMLElement($str);

		} catch (\Exception $e) {
			throw new \RuntimeException('Received string is not an xml.');
		}
	}

	private function parseJson($str)
	{
		return json_decode($str);
	}

	/**
	 * @param string $str xml
	 * @return SimpleXMLElement
	 */
	protected function handleXml($str)
	{
		$xml = $this->parseXml($str);
		if ($xml->getName() === 'error') {
			throw new InvalidMethodCallException("API responded with: " . $xml);
		}
		return $xml;
	}

}
