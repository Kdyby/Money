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
class Integer extends Nette\Object
{

	/**
	 * @var int
	 */
	protected $amount;



	/**
	 * @param int  $amount in currency subunit
	 */
	public function __construct($amount)
	{
		$this->amount = Math::parseInt($amount);
	}



	/**
	 * @param int|Integer $amount
	 * @return static
	 */
	public static function from($amount)
	{
		if ($amount instanceof self) {
			return new static($amount->toInt());
		}

		return new static($amount);
	}



	/**
	 * @return int
	 */
	public function toInt()
	{
		return $this->amount;
	}


	/********************* arithmetic *********************/


	/**
	 * @param static|int
	 * @return static
	 */
	public function add($amount)
	{
		return $this->copyWithAmount($this->toInt() + $this->valueToInt($amount));
	}



	/**
	 * @param static|int
	 * @return static
	 */
	public function sub($amount)
	{
		return $this->copyWithAmount($this->toInt() - $this->valueToInt($amount));
	}



	/**
	 * @param static|int
	 * @return static
	 */
	public function mul($amount)
	{
		return $this->copyWithAmount($this->toInt() * $this->valueToInt($amount));
	}



	/**
	 * @param static|int
	 * @return static
	 */
	public function div($amount)
	{
		return $this->copyWithAmount(Math::truncateDivision($this->toInt(), $this->valueToInt($amount)));
	}



	/**
	 * @return static
	 */
	public function negated()
	{
		return $this->copyWithAmount(-$this->amount);
	}


	/********************* comparing *********************/


	/**
	 * =
	 * @param static|int
	 * @return bool
	 */
	public function equals($amount)
	{
		return $this->toInt() === $this->valueToInt($amount);
	}



	/**
	 * <
	 * @param static|int
	 * @return bool
	 */
	public function lessThan($amount)
	{
		return $this->toInt() < $this->valueToInt($amount);
	}



	/**
	 * >
	 * @param static|int
	 * @return bool
	 */
	public function largerThan($amount)
	{
		return $this->toInt() > $this->valueToInt($amount);
	}



	/**
	 * <=
	 * @param static|int
	 * @return bool
	 */
	public function lessOrEquals($amount)
	{
		return $this->toInt() <= $this->valueToInt($amount);
	}



	/**
	 * >=
	 * @param static|int
	 * @return bool
	 */
	public function largerOrEquals($amount)
	{
		return $this->toInt() >= $this->valueToInt($amount);
	}



	/**
	 * @param static|int
	 * @return bool
	 */
	public function max($amount)
	{
		return $this->copyWithAmount(max($this->toInt(), $this->valueToInt($amount)));
	}



	/**
	 * @param static|int
	 * @return bool
	 */
	public function min($amount)
	{
		return $this->copyWithAmount(min($this->toInt(), $this->valueToInt($amount)));
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
	 * @param self|int|string|float $arg
	 * @throws InvalidArgumentException
	 * @return int
	 */
	protected function valueToInt($arg)
	{
		if ($arg instanceof self) {
			return $arg->toInt();
		}
		return Math::parseInt($arg);
	}



	/**
	 * @param static|int
	 * @return static
	 */
	public function copyWithAmount($value)
	{
		return new static($value);
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->amount;
	}

}
