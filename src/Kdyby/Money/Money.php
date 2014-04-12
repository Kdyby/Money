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
	public function __construct($amount, Currency $currency)
	{
		parent::__construct($amount);
		$this->currency = $currency;
	}



	/**
	 * @param float|int|string amount in currency main unit (fraction part is in subunit)
	 * @param Currency
	 * @return Money
	 */
	public static function fromFloat($amount, Currency $currency)
	{
		$amount = round($amount * $currency->getSubunitsInUnit());
		return new static(Math::parseInt($amount), $currency);
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
		if ($arg instanceof self && $this->currency !== $arg->currency) {
			throw new InvalidArgumentException();
		}
		return parent::valueToInt($arg);
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
//		return $this->truncated() . '.' . $this->paddedFractionPart(); //  . ' ' . $this->currency;
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
	 * @deprecated
	 * @return int
	 */
	public function getAmount()
	{
		$unscaled = $this->getCurrency()->unscaleAmount($this->toInt());
		return $unscaled < 0 ? (int) ceil($unscaled) : (int) floor($unscaled);
	}



	/**
	 * @deprecated
	 */
	public function getDecimals()
	{
		return abs($this->toInt()) % $this->currency->scaleAmount(1);
	}

}
