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
	 * @param  int
	 * @return int
	 */
	function scaleAmount($amount);

	/**
	 * @param  int
	 * @return float
	 */
	function unscaleAmount($amount);

}
