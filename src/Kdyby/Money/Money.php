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
 *
 * @property Currency $currency
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
	 * @param float|int|string amount in currency main unit (fraction part is in subunit)
	 * @param Currency
	 * @return Money
	 */
	public static function fromNumber($amount, Currency $currency)
	{
		$amount = round($amount * $currency->getSubunitsInUnit());
		return new static(Math::parseInt($amount), $currency);
	}


	/**
	 * @param int amount in currency subunit
	 * @param Currency
	 */
	public function __construct($amount, Currency $currency)
	{
		$this->currency = $currency;
		$this->amount = Math::parseInt($amount);
	}


	/**
	 * @return Currency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}


	/********************* arithmetic *********************/


	/**
	 * @param Money|int
	 * @return Money
	 */
	public function add($amount)
	{
		return $this->copyWithAmount($this->toInt() + $this->valueToInt($amount));
	}


	/**
	 * @param Money|int
	 * @return Money
	 */
	public function sub($amount)
	{
		return $this->copyWithAmount($this->toInt() - $this->valueToInt($amount));
	}


	/**
	 * @param Money|int
	 * @return Money
	 */
	public function mul($amount)
	{
		return $this->copyWithAmount($this->toInt() * $this->valueToInt($amount));
	}


	/**
	 * @param Money|int
	 * @return Money
	 */
	public function div($amount)
	{
		return $this->copyWithAmount(Math::truncDiv($this->toInt(), $this->valueToInt($amount)));
	}


	/**
	 * @return Money
	 */
	public function negated()
	{
		return $this->copyWithAmount(-$this->amount);
	}


	/**
	 * @return int
	 */
	public function truncated()
	{
		return Math::quotient($this->toInt(), $this->currency->subunitsInUnit);
	}



	/**
	 * @return int
	 */
	public function fractionPart()
	{
		return $this->toInt() % $this->currency->subunitsInUnit;
	}


	/********************* comparing *********************/


	/**
	 * =
	 * @param Money|int
	 * @return bool
	 */
	public function equals($amount)
	{
		return $this->toInt() === $this->valueToInt($amount);
	}


	/**
	 * <
	 * @param Money|int
	 * @return bool
	 */
	public function lessThan($amount)
	{
		return $this->toInt() < $this->valueToInt($amount);
	}


	/**
	 * >
	 * @param Money|int
	 * @return bool
	 */
	public function largerThan($amount)
	{
		return $this->toInt() > $this->valueToInt($amount);
	}


	/**
	 * <=
	 * @param Money|int
	 * @return bool
	 */
	public function lessOrEquals($amount)
	{
		return $this->toInt() <= $this->valueToInt($amount);
	}


	/**
	 * >=
	 * @param Money|int
	 * @return bool
	 */
	public function largerOrEquals($amount)
	{
		return $this->toInt() >= $this->valueToInt($amount);
	}


	/**
	 * @return bool
	 */
	public function isZero()
	{
		return $this->toInt() === 0;
	}


	/********************* converting *********************/


	/**
	 * @param self|int|string|float
	 * @return int
	 */
	private function valueToInt($arg)
	{
		if ($arg instanceof self) {
			if ($this->currency !== $arg->currency) {
				throw new InvalidArgumentException();
			}
			return $arg->toInt();
		}
		return Math::parseInt($arg);
	}


	/**
	 * @param Money|int
	 * @return Money
	 */
	public function copyWithAmount($value)
	{
		return new static($value, $this->currency);
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
		return (float) ($this->toInt() / $this->currency->subunitsInUnit);
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->truncated() . '.' . $this->paddedFractionPart() . ' ' . $this->currency;
	}



	/**
	 * @param string
	 * @return string
	 */
	public function format($format)
	{
		return sprintf(
			$format,
			$this->truncated(),
			$this->paddedFractionPart(),
			$this->currency->getCode(),
			$this->currency->getName()
		);
	}



	private function paddedFractionPart()
	{
		return str_pad(abs($this->fractionPart()), $this->currency->computePrecision(), '0', STR_PAD_LEFT);
	}

}
