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

		} elseif ($amount !== NULL && abs($amount) != 0) {
			if (number_format($amount, 0, '', '') !== (string)$amount) {
				throw new InvalidArgumentException("Only whole numbers are allowed, $amount given.");
			}

			$this->sign = (abs($amount) == $amount ? 1 : -1);
			if ($currency->getDecimals() > 0) {
				$this->decimals = abs((int) (substr($amount, -($currency->getDecimals())) ?: 0));
				$amount = substr($amount, 0, -($currency->getDecimals())) ?: 0;
			}

			$this->amount = abs((int) ($amount ?: 0));
		}
	}



	/**
	 * @return int
	 */
	public function getAmount()
	{
		return $this->sign * (int) $this->amount;
	}



	/**
	 * @return int
	 */
	public function getDecimals()
	{
		return (int) $this->decimals;
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
		$this->assertSameCurrency($amount);

		return new Money(self::unwrap($this) + self::unwrap($amount), $this->currency);
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return Money
	 */
	public function sub($amount)
	{
		$this->assertSameCurrency($amount);

		return new Money(self::unwrap($this) - self::unwrap($amount), $this->currency);
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function equals($amount)
	{
		$this->assertSameCurrency($amount);

		return self::unwrap($this) === self::unwrap($amount);
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function largerThan($amount)
	{
		$this->assertSameCurrency($amount);

		return self::unwrap($this) > self::unwrap($amount);
	}



	/**
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function largerOrEquals($amount)
	{
		$this->assertSameCurrency($amount);

		return self::unwrap($this) >= self::unwrap($amount);
	}



	/**
	 * @return bool
	 */
	public function isZero()
	{
		return self::unwrap($this) === 0;
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



	/**
	 * @param mixed $value
	 * @return int
	 */
	private static function unwrap($value)
	{
		if ($value instanceof Money) {
			return (int) $value->__toString();
		}

		return (int) $value;
	}

}
