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
final class NullCurrency extends Currency
{

	public function __construct()
	{
		parent::__construct('NULL', 1, '', '', array());
	}



	public function isInterchangeable(Currency $currency)
	{
		return TRUE;
	}

}
