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
	private $amount = 0;

	/**
	 * @var integer
	 */
	private $sign = 1;

	/**
	 * @var integer
	 */
	private $decimals = 0;

	/**
	 * @var ICurrency
	 */
	private $currency;



	public function __construct($amount, ICurrency $currency)
	{
		$this->currency = $currency;

		if ($amount instanceof Money) {
			$this->assertSameCurrency($amount);

			$this->sign = (int) $amount->sign;
			$this->amount = (int) $amount->amount;
			$this->decimals = (int) $amount->decimals;

		} elseif ($amount !== NULL && ($formatted = number_format($amount, 0, '', '')) !== '0') {
			if ($formatted !== (string) $amount) {
				throw new InvalidArgumentException("Only whole numbers are allowed, $amount given.");
			}

			$this->sign = $formatted[0] === '-' ? -1 : 1;
			if (($currencyDecimals = $currency->getDecimals()) > 0) {
				$adjustment = $this->sign === -1;
				$this->decimals = (int) substr($formatted, -min(strlen($formatted) - $adjustment, $currencyDecimals)) ?: 0;
				$amount = substr($formatted, $adjustment, -$currencyDecimals) ?: 0;
			}

			$this->amount = (int) $amount;
		}
	}



	/**
	 * @return int
	 */
	public function getAmount()
	{
		return $this->sign * $this->amount;
	}



	/**
	 * @return int
	 */
	public function getDecimals()
	{
		return $this->decimals;
	}



	/**
	 * @return ICurrency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return Money
	 */
	public function add($amount)
	{
		return MoneyComputer::getInstance()->add($this, $this->createFromAmount($amount));
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return Money
	 */
	public function sub($amount)
	{
		return MoneyComputer::getInstance()->subtract($this, $this->createFromAmount($amount));
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function equals($amount)
	{
		return MoneyComputer::getInstance()->equals($this, $this->createFromAmount($amount));
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function largerThan($amount)
	{
		return MoneyComputer::getInstance()->largerThan($this, $this->createFromAmount($amount));
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function largerOrEquals($amount)
	{
		return MoneyComputer::getInstance()->largerOrEquals($this, $this->createFromAmount($amount));
	}



	/**
	 * @return bool
	 */
	public function isZero()
	{
		return MoneyComputer::getInstance()->equals($this, 0);
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) ($this->sign * ($this->amount * pow(10, $this->currency->getDecimals()) + $this->decimals));
	}



	private function assertSameCurrency($value)
	{
		if ($value instanceof Money && $value->currency !== $this->currency) {
			throw new InvalidArgumentException(
				"Given value has currency {$value->currency->getCode()}, but {$this->currency->getCode()} was expected. " .
				"To operate on these two objects, use currency table and convert the value first."
			);
		}
	}


	private function createFromAmount($value)
	{
		if ($value instanceof self) {
			$this->assertSameCurrency($value);

		} else {
			$value = new $this($value, $this->currency);
		}
		return $value;
	}

}
