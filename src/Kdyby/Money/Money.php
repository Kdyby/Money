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

		if ($amount instanceof Money) {
			$this->amount = (int) $amount->amount;
			$this->decimals = (int) $amount->decimals;

		} else {
			if (number_format($amount, 0, '', '') !== (string)$amount) {
				throw new InvalidArgumentException("Only whole numbers are allowed, $amount given.");
			}

			if ($currency->getDecimals() > 0) {
				$this->decimals = (int) (substr($amount, -($currency->getDecimals())) ?: 0);
				$amount = substr($amount, 0, -($currency->getDecimals()));
			}
			$this->amount = (int) ($amount ?: 0);
		}
	}



	/**
	 * @return int
	 */
	public function getAmount()
	{
		return (int) $this->amount;
	}



	/**
	 * @return int
	 */
	public function getDecimals()
	{
		return (int) $this->decimals;
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
		if ($this->amount == 0) {
			return (string) $this->decimals;
		}

		return (string) $this->amount . str_pad($this->decimals, $this->currency->getDecimals(), '0', STR_PAD_LEFT);
	}

}
