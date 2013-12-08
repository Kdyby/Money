<?php

namespace Kdyby\Money;


interface ICalculator
{

	/** @param int */
	function __construct($precision);

	function add($a, $b);

	function divide($a, $b);

	function subtract($a, $b);

	function multiply($a, $b);

	/**
	 * Converts value to internal representation used for computations
	 * @param float|string|int
	 * @return mixed
	 * @throws \Kdyby\Money\InvalidArgumentException
	 */
	function convertFromScalar($value);

	/**
	 * Converts value from internal representation to scalar value
	 * @return float|string|int
	 * @throws \Kdyby\Money\InvalidArgumentException
	 */
	function convertToScalar($value);

}
