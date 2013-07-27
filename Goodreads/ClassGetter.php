<?php

namespace Goodreads;

class ClassGetter
{

	public function get(Goodreads $api, $class)
	{
		$class = "Goodreads\\Classes\\" . ucFirst($class);
		if (!class_exists($class)) {
			throw new InvalidApiGetterException("API class `$class` does not exist.");
		}

		return new $class($api);
	}
	
}
