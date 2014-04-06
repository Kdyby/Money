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
 * @author Ladislav Marek <ladislav@marek.su>
 */
abstract class Exchanger extends Nette\Object
{


	/**
	 * @param Money $money
	 * @param Currency $to
	 * @return Money
	 */
	public function convert(Money $money, Currency $to)
	{
		$amount = $money->toFloat() * $this->calculateExchangeRate($money->getCurrency(), $to);
		return new $money($to->scaleAmount($amount), $to);
	}



	/**
	 * @param Currency $from
	 * @param Currency $to
	 * @return float
	 */
	public function calculateExchangeRate(Currency $from, Currency $to)
	{
		$fromRate = (float) $this->getRate($from) ?: 1.0;
		$toRate = (float) $this->getRate($to) ? : 1.0;

		return $fromRate / $toRate;
	}



	/**
	 * @param Currency $currency
	 * @return float
	 */
	abstract public function getRate(Currency $currency);

}
