<?php

namespace Goodreads\Classes;

/**
 * @method mixed show($id)
 */
class User extends BaseClass
{

	/**
	 * Either id or username is required
	 * @url /user/show.xml
	 * @param int $id {optional}
	 * @param int $username {optional}
	 * @see http://www.goodreads.com/api#user.show
	 */
	protected function methodShow($response)
	{
		return $this->handleXml($response);
	}

}
