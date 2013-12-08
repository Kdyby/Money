<?php

namespace Kdyby\Money\Calculators;

use Nette;
use Kdyby;


class BCMathCalculator extends Nette\Object implements Kdyby\Money\ICalculator
{

	/** @var int|null */
	private $scale;


	/**
	 * @param int|null
	 */
	public function __construct($scale = NULL)
	{
		$this->scale = $scale;
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function add($a, $b)
	{
		return bcadd($a, $b, $this->scale);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function divide($a, $b)
	{
		return bcdiv($a, $b, $this->scale);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function modulo($a, $b)
	{
		return bcmod($a, $b, $this->scale);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function multiply($a, $b)
	{
		return bcmul($a, $b, $this->scale);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function power($base, $exponent)
	{
		return bcpow($base, $exponent, $this->scale);
	}


	/**
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function powerModulo($base, $exponent, $modulo)
	{
		// Exponent in fold of tens of thousands leads to overflow. Result is then 1.
		return $exponent > '9999' ? bcmod(bcpow($base, $exponent), $modulo) : bcpowmod($base, $exponent, $modulo);
	}


	/**
	 * @param string
	 * @return string
	 */
	public function squareRoot($a)
	{
		return bcsqrt($a, $this->scale);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function subtract($a, $b)
	{
		return bcsub($a, $b, $this->scale);
	}


	/**
	 * @param string
	 * @param string
	 * @inheritdoc
	 */
	public function compare($a, $b)
	{
		// TODO '-0.0' != '0.0'
		return bccomp($a, $b, $this->scale);
	}


	public function convertToType($value, $type)
	{
		if ($type !== 'string') {
			throw new Kdyby\Money\InvalidArgumentException("BCMathCalculator only supports conversion to string.");
		}

		if (!is_numeric($value)) {
			throw new Kdyby\Money\InvalidArgumentException("BCMathCalculator only supports conversion from numeric value.");
		}

		return (string) $value;
	}


	public function convertFromType($value, $type)
	{
		if ($type !== 'string') {
			throw new Kdyby\Money\InvalidArgumentException("BCMathCalculator only supports conversion from string.");
		}

		return $value;
	}

}
