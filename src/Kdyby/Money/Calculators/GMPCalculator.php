<?php

namespace Kdyby\Money\Calculators;

use Nette;
use Kdyby;


class GMPCalculator extends Nette\Object implements Kdyby\Money\ICalculator
{

	/**
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function add($a, $b)
	{
		return gmp_add($a, $b);
	}


	/**
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function subtract($a, $b)
	{
		return gmp_sub($a, $b);
	}


	/**
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function multiply($a, $b)
	{
		return gmp_mul($a, $b);
	}


	/**
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function divide($a, $b)
	{
		return gmp_div_q($a, $b);
	}


	/**
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function modulo($a, $b)
	{
		return gmp_mod($a, $b);
	}


	/**
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function power($base, $exponent)
	{
		return gmp_pow($base, $exponent);
	}


	/**
	 * @param resource
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function powerModulo($base, $exponent, $modulo)
	{
		return gmp_powm($base, $exponent, $modulo);
	}


	/**
	 * @param resource
	 * @return resource
	 */
	public function squareRoot($a)
	{
		return gmp_sqrt($a);
	}


	/**
	 * @param resource $a
	 * @param resource $b
	 * @inheritdoc
	 */
	public function compare($a, $b)
	{
		return gmp_cmp($a, $b);
	}


	public function convertToType($value, $type)
	{
		if ($type !== 'resource') {
			throw new Kdyby\Money\InvalidArgumentException("GMPCalculator only supports conversion to resource.");
		}

		if (!is_numeric($value)) {
			throw new Kdyby\Money\InvalidArgumentException("GMPCalculator only supports conversion from numeric value.");
		}

		return gmp_init($value);
	}


	public function convertFromType($value, $type)
	{
		if ($type !== 'resource') {
			throw new Kdyby\Money\InvalidArgumentException("GMPCalculator only supports conversion from resource.");
		}

		return gmp_strval($value);
	}

}
