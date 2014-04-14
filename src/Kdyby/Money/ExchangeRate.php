<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money;

use Kdyby;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ExchangeRate extends Nette\Object
{

	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var \Datetime
	 */
	protected $since;

	/**
	 * @var \Datetime
	 */
	protected $till;

	/**
	 * @var Currency
	 */
	protected $buy;

	/**
	 * @var Currency
	 */
	protected $sell;



	/**
	 * @return int
	 */
	final public function getId()
	{
		return $this->id;
	}

}
