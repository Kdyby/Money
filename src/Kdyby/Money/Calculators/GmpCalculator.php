<?php

namespace Kdyby\Money\Calculators;

use Nette;
use Kdyby;


class GmpCalculator extends Nette\Object implements Kdyby\Money\ICalculator, Kdyby\Money\IComparator
{

	/** @var int */
	private $precision;

	/** @var resource */
	private $scale;


	public function __construct($precision = 8)
	{
		$this->precision = (int) $precision;
		$this->scale = gmp_pow(10, $this->precision);
	}


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
	public function divide($a, $b)
	{
		return $this->precision === 0 ? gmp_div_q($a, $b) : gmp_div_q(gmp_mul($a, $this->scale), $b);
	}


	/**
	 * @param resource
	 * @param resource
	 * @return resource
	 */
	public function multiply($a, $b)
	{
		return $this->precision === 0 ? gmp_mul($a, $b) : gmp_div_q(gmp_mul($a, $b), $this->scale);
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
	 * @param resource $a
	 * @param resource $b
	 * @inheritdoc
	 */
	public function compare($a, $b)
	{
		return gmp_cmp($a, $b);
	}


	/**
	 * @inheritdoc
	 * @return resource
	 */
	public function convertFromScalar($value)
	{
		if (!is_numeric($value)) {
			throw new Kdyby\Money\InvalidArgumentException('GmpCalculator only supports conversion from numeric value.');
		}

		if (!is_string($value)) {
			$value = number_format($value, $this->precision, '.', '');
		}

		return gmp_init($this->precision === 0 ? $value : $this->adjustValueToPrecision($value));
	}


	/**
	 * @inheritdoc
	 * @param resource
	 * @return string
	 */
	public function convertToScalar($value)
	{
		if (!is_resource($value)) {
			throw new Kdyby\Money\InvalidArgumentException('GmpCalculator only supports conversion from resource.');
		}

		return $this->precision === 0 ? gmp_strval($value) : $this->adjustValueFromPrecision(gmp_strval($value));
	}


	/**
	 * @param float|string|int
	 * @return string
	 */
	private function adjustValueToPrecision($value)
	{
		$parts = explode('.', is_string($value) ? $value : number_format($value, $this->precision, '.', ''), 2);
		return $parts[0] . substr(str_pad(isset($parts[1]) ? $parts[1] : '', $this->precision, '0', STR_PAD_RIGHT), 0, $this->precision);
	}


	/**
	 * @param string
	 * @return string
	 */
	private function adjustValueFromPrecision($value)
	{
		if ($negative = ($value[0] === '-')) {
			$value = substr($value, 1);
		}

		$decimals = rtrim(substr($value, -$this->precision), '0');
		return ($negative ? '-' : '') . (substr($value, 0, -$this->precision) ?: '0') . ($decimals ? '.' . $decimals : '');
	}

}
