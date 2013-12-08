<?php

namespace Kdyby\Money\Calculators;

use Nette;
use Kdyby;


class BcMathCalculator extends Nette\Object implements Kdyby\Money\ICalculator, Kdyby\Money\IComparer
{

	/** @var int */
	private $precision;


	public function __construct($precision)
	{
		$this->precision = (int) $precision;
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function add($a, $b)
	{
		return bcadd($a, $b, $this->precision);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function divide($a, $b)
	{
		return bcdiv($a, $b, $this->precision);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function multiply($a, $b)
	{
		return bcmul($a, $b, $this->precision);
	}


	/**
	 * @param string
	 * @param string
	 * @return string
	 */
	public function subtract($a, $b)
	{
		return bcsub($a, $b, $this->precision);
	}


	/**
	 * @param string
	 * @param string
	 * @inheritdoc
	 */
	public function compare($a, $b)
	{
		// TODO '-0.0' != '0.0'
		return bccomp($a, $b, $this->precision);
	}


	/**
	 * @inheritdoc
	 * @return string
	 */
	public function convertFromScalar($value)
	{
		if (!is_numeric($value)) {
			throw new Kdyby\Money\InvalidArgumentException('BcMathCalculator only supports conversion to numeric value.');
		}

		return is_float($value) ? number_format($value, $this->precision, '.', '') : (string) $value;
	}


	/**
	 * @param string
	 * @return string
	 */
	public function convertToScalar($value)
	{
		if (!is_string($value)) {
			throw new Kdyby\Money\InvalidArgumentException('BcMathCalculator only supports conversion from string to string.');
		}

		return $value;
	}

}
