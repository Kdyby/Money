<?php

namespace Kdyby\Money\Calculators;

use Nette;
use Kdyby;


class NativeCalculator extends Nette\Object implements Kdyby\Money\ICalculator
{

	/**
	 * @param float|int|string
	 * @param float|int|string
	 * @return float|int
	 */
	public function add($a, $b)
	{
		return $a + $b;
	}


	/**
	 * @param float|int|string
	 * @param float|int|string
	 * @return float|int
	 */
	public function subtract($a, $b)
	{
		return $a - $b;
	}


	/**
	 * @param float|int|string
	 * @param float|int|string
	 * @return float|int
	 */
	public function multiply($a, $b)
	{
		return $a * $b;
	}


	/**
	 * @param float|int|string
	 * @param float|int|string
	 * @return float|int
	 */
	public function divide($a, $b)
	{
		return $a / $b;
	}


	/**
	 * @param float|int|string
	 * @param float|int|string
	 * @return int
	 */
	public function modulo($a, $b)
	{
		return $a % $b;
	}


	/**
	 * @param float|int|string
	 * @param float|int|string
	 * @return float|int
	 */
	public function power($base, $exponent)
	{
		return pow($base, $exponent);
	}


	/**
	 * @param float|int|string
	 * @param float|int|string
	 * @param float|int|string
	 * @return int
	 */
	public function powerModulo($base, $exponent, $modulo)
	{
		return $this->modulo($this->power($base, $exponent), $modulo);
	}


	/**
	 * @param float|int|string
	 * @return float
	 */
	public function squareRoot($a)
	{
		return sqrt($a);
	}


	/**
	 * Returns -1, 0 or 1 if $a > $b, $a == $b or $a < $b.
	 * @param float|int|string
	 * @param float|int|string
	 * @return int
	 */
	public function compare($a, $b)
	{
		return $a == $b ? 0
			: $a > $b ? -1 : 1;
	}


	public function convertToType($value, $type)
	{
		if (!is_numeric($value)) {
			throw new Kdyby\Money\InvalidArgumentException("NativeCalculator only supports numeric values.");
		}

		if (!is_scalar($value)) {
			throw new Kdyby\Money\InvalidArgumentException("GMPCalculator only supports conversion from scalar value.");
		}

		return (string) $value;
	}


	public function convertFromType($value, $type)
	{
		if (!is_scalar($value)) {
			throw new Kdyby\Money\InvalidArgumentException("GMPCalculator only supports conversion to scalar value.");
		}

		return $value;
	}

}
