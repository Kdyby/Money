<?php

namespace Kdyby\Money\Calculators;

use Nette;
use Kdyby;


class NativeCalculator extends Nette\Object implements Kdyby\Money\ICalculator, Kdyby\Money\IComparator
{

	/** @var int */
	private $precision;

	/** @var int */
	private $scale;


	public function __construct($precision = 8)
	{
		$this->precision = (int) $precision;
		$this->scale = pow(10, $this->precision);
	}

	/**
	 * @param float|int
	 * @param float|int
	 * @return float|int
	 */
	public function add($a, $b)
	{
		return floor($a + $b);
	}


	/**
	 * @param float|int
	 * @param float|int
	 * @return float|int
	 */
	public function subtract($a, $b)
	{
		return floor($a - $b);
	}


	/**
	 * @param float|int
	 * @param float|int
	 * @return float|int
	 */
	public function divide($a, $b)
	{
		return $this->precision === 0 ? floor($a / $b) : floor(($a * $this->scale) / $b);
	}


	/**
	 * @param float|int
	 * @param float|int
	 * @return float|int
	 */
	public function multiply($a, $b)
	{
		return $this->precision === 0 ? floor($a * $b) : floor(($a * $b) / $this->scale);
	}


	/**
	 * Returns -1, 0 or 1 if $a > $b, $a == $b or $a < $b.
	 * @param float|int
	 * @param float|int
	 * @return int
	 */
	public function compare($a, $b)
	{
		$a = number_format($a, $this->precision, '.', '');
		$b = number_format($b, $this->precision, '.', '');
		return $a == $b ? 0 : ($a > $b ? -1 : 1);
	}


	/**
	 * @inheritdoc
	 * @return float|int
	 */
	public function convertFromScalar($value)
	{
		if (!is_numeric($value)) {
			throw new Kdyby\Money\InvalidArgumentException('NativeCalculator only supports numeric values.');
		}

		return $this->precision === 0 ? floor($value) : floor($value * $this->scale);
	}


	/**
	 * @inheritdoc
	 * @param float|int
	 * @return float|int
	 */
	public function convertToScalar($value)
	{
		if (!is_int($value) && !is_float($value)) {
			throw new Kdyby\Money\InvalidArgumentException('NativeCalculator only supports conversion from int and float to scalar value.');
		}

		return $this->precision === 0 ? $value : $value / $this->scale;
	}

}
