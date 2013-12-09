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
	 * @var string
	 */
	private $value = '0';

	/**
	 * @var int
	 */
	private $amount;

	/**
	 * @var int
	 */
	private $decimals;

	/**
	 * @var string
	 */
	private $decimalValue;

	/**
	 * @var ICurrency
	 */
	private $currency;



	public function __construct($value, ICurrency $currency)
	{
		$this->currency = $currency;

		if ($value instanceof self) {
			$this->assertSameCurrency($value);
			$this->value = $value->value;
			$this->amount = $value->amount;
			$this->decimals = $value->decimals;

		} elseif ($value != 0) {
			$original = $value;
			if (!is_string($value)) {
				$value = number_format($value, 0, '', '');
				if ($value !== (string) $original) {
					throw new InvalidArgumentException("Only integers are allowed, $original given.");
				}
			}
			if (($decimals = strrchr($value, '.')) !== FALSE) {
				if (rtrim($decimals, '0') !== '.') {
					throw new InvalidArgumentException("Only integers are allowed, $original given.");
				}
				$value = substr($value, 0, strlen($decimals));
			}
			$this->value = $value;
		}
	}



	/**
	 * @return int
	 */
	public function getAmount()
	{
		$this->parseValue();
		return $this->amount;
	}



	/**
	 * @return int
	 */
	public function getDecimals()
	{
		$this->parseValue();
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
	 * @deprecated
	 * @param int|float|string|Money $amount
	 * @return Money
	 */
	public function add($amount)
	{
		return static::getComputerInstance()->add($this, $this->createFromAmount($amount));
	}



	/**
	 * @deprecated
	 * @param int|float|string|Money $amount
	 * @return Money
	 */
	public function sub($amount)
	{
		return static::getComputerInstance()->subtract($this, $this->createFromAmount($amount));
	}



	/**
	 * @deprecated
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function equals($amount)
	{
		return static::getComputerInstance()->equals($this, $this->createFromAmount($amount));
	}



	/**
	 * @deprecated
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function largerThan($amount)
	{
		return static::getComputerInstance()->largerThan($this, $this->createFromAmount($amount));
	}



	/**
	 * @deprecated
	 * @param int|float|string|Money $amount
	 * @return bool
	 */
	public function largerOrEquals($amount)
	{
		return static::getComputerInstance()->largerOrEquals($this, $this->createFromAmount($amount));
	}



	/**
	 * @deprecated
	 * @return bool
	 */
	public function isZero()
	{
		return static::getComputerInstance()->equals($this, 0);
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->value;
	}



	/**
	 * @return string
	 */
	public function toDecimal()
	{
		$this->parseValue();
		return $this->decimalValue;
	}



	/**
	 * @return float
	 */
	public function toFloat()
	{
		$this->parseValue();
		return (float) $this->decimalValue;
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


	private function parseValue()
	{
		if ($this->amount === NULL) {
			$sign = substr($this->value, 0, 1) === '-' ? -1 : 1;
			$adjustment = $sign === -1;
			if (($currencyDecimals = $this->currency->getDecimals()) > 0) {
				$this->decimals = (int) ($decimals = substr($this->value, -min(strlen($this->value) - $adjustment, $currencyDecimals))) ?: 0;

			} else {
				$this->decimals = 0;
			}
			$this->amount = (int) $sign * (($amount = substr($this->value, $adjustment, -$currencyDecimals)) ?: 0);
			$this->decimalValue = ($sign === -1 ? '-' : '') . ($amount ?: '0') . ($currencyDecimals > 0 ? '.' . str_pad($decimals, $currencyDecimals, '0', STR_PAD_LEFT) : '');
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


	/**
	 * @deprecated
	 */
	private static function getComputerInstance()
	{
		static $instance = NULL;
		if ($instance === NULL) {
			return $instance = new MoneyComputer;
		}

		return $instance;
	}

}
