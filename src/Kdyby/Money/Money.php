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
 * @author Filip Procházka <filip@prochazka.su>
 * @author Ladislav Marek <ladislav@marek.su>
 */
class Money extends Nette\Object
{

	/**
	 * @var int
	 */
	private $amount;

	/**
	 * @var Currency
	 */
	private $currency;



	/**
	 * @param Money|int|float|string
	 * @param Currency
	 */
	public function __construct($amount, Currency $currency)
	{
		$this->currency = $currency;
		$this->amount = $this->valueOf($amount);
	}



	/**
	 * @return int
	 */
	public function getAmount()
	{
		$unscaled = $this->currency->unscaleAmount($this->amount);
		return $unscaled < 0 ? (int) ceil($unscaled) : (int) floor($unscaled);
	}



	/**
	 * @return Currency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}



	/**
	 * @return int
	 */
	public function getDecimals()
	{
		return abs($this->amount) % $this->currency->scaleAmount(1);
	}



	/**
	 * @param Money|int|float|string $amount
	 * @return Money
	 */
	public function add($amount)
	{
		return $this->copyWithValue($this->toInt() + $this->valueOf($amount));
	}



	/**
	 * @param Money|int|float|string $amount
	 * @return Money
	 */
	public function sub($amount)
	{
		return $this->copyWithValue($this->toInt() - $this->valueOf($amount));
	}



	/**
	 * @param Money|int|float|string $amount
	 * @return bool
	 */
	public function equals($amount)
	{
		return $this->toInt() === $this->valueOf($amount);
	}



	/**
	 * @param Money|int|float|string $amount
	 * @return bool
	 */
	public function largerThan($amount)
	{
		return $this->toInt() > $this->valueOf($amount);
	}



	/**
	 * @param Money|int|float|string $amount
	 * @return bool
	 */
	public function largerOrEquals($amount)
	{
		return $this->toInt() >= $this->valueOf($amount);
	}


	/**
	 * @param Money|int|float|string
	 * @return Money
	 */
	public function copyWithValue($value)
	{
		return new static($value, $this->currency);
	}



	/**
	 * @return bool
	 */
	public function isZero()
	{
		return $this->toInt() === 0;
	}



	/**
	 * @param int
	 */
	public function toInt()
	{
		return $this->amount;
	}



	/**
	 * @return float
	 */
	public function toFloat()
	{
		return $this->currency->unscaleAmount($this->amount);
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->toInt();
	}



	/**
	 * @param Money|int|float|string $value
	 * @throws InvalidArgumentException
	 * @return int
	 */
	private function valueOf($value)
	{
		if ($value instanceof self) {
			if (!$value->isZero() && $this->currency !== $value->currency) {
				throw new InvalidArgumentException(
					"Given value has currency {$value->currency->getCode()}, but {$this->currency->getCode()} was expected. " .
					"To operate on these two objects, use currency table and convert the value first."
				);
			}

			return $value->toInt();

		} elseif (round($value) === round($value, 10)) {
			return (int) round($value, 10);
		}

		throw new InvalidArgumentException("Only whole numbers are allowed, $value given.");
	}

}
