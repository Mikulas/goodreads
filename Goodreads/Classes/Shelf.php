<?php

namespace Goodreads\Classes;

/**
 * @method list(array $options)
 */
class Shelf extends BaseClass
{

	/**
	 * @url /review/list?v=2
	 * @param int $id
	 * @param string $shelf {optional}
	 * @param string $sort {optional}
	 * @param string $search {optional}
	 * @param string $order {optional}
	 * @param int $page {optional}
	 * @param int $per_page {optional}
	 * 
	 * @see http://www.goodreads.com/api#reviews.list
	 */
	protected function methodList($response)
	{
		return $this->handleXml($response);
	}

}
