<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money;

use Nette;



/**
 * @author Michal Gebauer <mishak@mishak.net>
 */
interface ICurrency
{

	/**
	 * Must be unique across all ICurrency implementations and rather short
	 * @return string
	 */
	function getCode();

	/**
	 * @return int
	 */
	function getDecimals();

	/**
	 * @throws SingletonException
	 */
	function __clone();

	/**
	 * @throws SingletonException
	 */
	function __wakeup();

	/**
	 * @throws SingletonException
	 */
	static function __set_state($an_array);

}
