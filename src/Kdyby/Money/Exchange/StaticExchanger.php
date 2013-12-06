<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money\Exchange;

use Kdyby;
use Kdyby\Money\Currency;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class StaticExchanger extends Kdyby\Money\Exchanger
{

	/**
	 * @var array
	 */
	private $rates;



	public function __construct(array $rates)
	{
		foreach ($rates as $code => $rate) {
			$this->rates[Kdyby\Money\Currency::get($code)->getCode()] = $rate;
		}
	}



	/**
	 * @param \Kdyby\Money\Currency $currency
	 * @return float
	 */
	public function getRate(Currency $currency)
	{
		return (float) $this->rates[$currency->getCode()];
	}

}
