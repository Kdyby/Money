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
	 * @var int
	 */
	private $amount;

	/**
	 * @var ICurrency
	 */
	private $currency;



	/**
	 * @param self|scalar
	 * @param ICurrency
	 */
	public function __construct($amount, ICurrency $currency)
	{
		$this->currency = $currency;
		$this->amount = $this->valueOf($amount);
	}



	/**
	 * @return int
	 */
	public function getAmount()
	{
		return (int) round($this->currency->unscaleAmount($this->amount));
	}



	/**
	 * @return ICurrency
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
	 * @param self|scalar $amount
	 * @return self
	 */
	public function add($amount)
	{
		return $this->copyWithValue($this->toInt() + $this->valueOf($amount));
	}



	/**
	 * @param self|scalar $amount
	 * @return self
	 */
	public function sub($amount)
	{
		return $this->copyWithValue($this->toInt() - $this->valueOf($amount));
	}



	/**
	 * @param self|scalar $amount
	 * @return bool
	 */
	public function equals($amount)
	{
		return $this->toInt() === $this->valueOf($amount);
	}



	/**
	 * @param self|scalar $amount
	 * @return bool
	 */
	public function largerThan($amount)
	{
		return $this->toInt() > $this->valueOf($amount);
	}



	/**
	 * @param self|scalar $amount
	 * @return bool
	 */
	public function largerOrEquals($amount)
	{
		return $this->toInt() >= $this->valueOf($amount);
	}


	/**
	 * @param  self|scalar
	 * @return self
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
	 * @param self|scalar
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
		} elseif (round($value) === round((float) $value, 3)) {
			return (int) $value;
		}

		throw new InvalidArgumentException("Only whole numbers are allowed, $value given.");
	}

}
