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
class Money extends Nette\Object
{

	/**
	 * @var integer
	 */
	private $amount;

	/**
	 * @var integer
	 */
	private $decimals;

	/**
	 * @var Currency
	 */
	private $currency;



	public function __construct($amount, Currency $currency)
	{
		$this->currency = $currency;

		if ($currency->getDecimals() > 0) {
			$this->decimals = substr($amount, -($currency->getDecimals()));
			$amount = substr($amount, 0, -($currency->getDecimals()));
		}
		$this->amount = $amount;
	}



	/**
	 * @return int
	 */
	public function getAmount()
	{
		return $this->amount;
	}



	/**
	 * @return int
	 */
	public function getDecimals()
	{
		return $this->decimals;
	}



	/**
	 * @return Currency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->amount . '.' . $this->decimals;
	}

}
