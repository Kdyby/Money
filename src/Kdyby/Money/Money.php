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
class Money extends Integer
{

	/**
	 * @var Currency
	 */
	private $currency;



	/**
	 * @param int $amount in currency subunit
	 * @param Currency $currency
	 */
	public function __construct($amount, Currency $currency = NULL)
	{
		parent::__construct($amount);
		$this->currency = $currency ?: new NullCurrency();
	}



	/**
	 * @param float|int|string amount in currency main unit (fraction part is in subunit)
	 * @param Currency
	 * @return Money
	 */
	public static function fromFloat($amount, Currency $currency = NULL)
	{
		$currency = $currency ? : new NullCurrency();
		$amount = round(Math::parseNumber($amount) * $currency->getSubunitsInUnit());
		return new static($amount, $currency);
	}



	/**
	 * @param int|Integer $amount
	 * @param Currency $currency
	 * @throws InvalidArgumentException
	 * @return static
	 */
	public static function from($amount, Currency $currency = NULL)
	{
		$currency = $currency ? : new NullCurrency();

		if ($amount instanceof self) {
			return new static($amount->toInt(), $currency);
		}

		return new static($amount, $currency);
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



	/********************* converting *********************/



	protected function valueToInt($arg)
	{
		if ($arg instanceof Money && !$arg->currency->isInterchangeable($this->currency)) {
			throw new InvalidArgumentException("Currency $arg->currency is not compatible with $this->currency.");
		}
		return parent::valueToInt($arg);
	}



	protected function valueToNumber($arg)
	{
		if ($arg instanceof Money && !$arg->currency->isInterchangeable($this->currency)) {
			throw new InvalidArgumentException("Currency $arg->currency is not compatible with $this->currency.");
		}
		return parent::valueToNumber($arg);
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
		return (string) $this->toInt();
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



	/**
	 * @deprecated replaced with self::truncated()
	 */
	public function getAmount()
	{
		return $this->truncated();
	}



	/**
	 * @deprecated replaced with abs(self::fractionPart())
	 */
	public function getDecimals()
	{
		return abs($this->fractionPart());
	}



	/**
	 * @deprecated replaced with self::copyWithAmount()
	 */
	public function copyWithValue($value)
	{
		return new static($value, $this->currency);
	}

}
