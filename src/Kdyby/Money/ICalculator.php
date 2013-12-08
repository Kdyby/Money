<?php

namespace Kdyby\Money;


interface ICalculator
{

	/**
	 * Returns -1, 0 or 1 if $a > $b, $a == $b or $a < $b.
	 * @return int
	 */
	function compare($a, $b);

	/**
	 * Type is taken from function annotation.
	 * Must throw InvalidArgumentException on unsupported $type.
	 *
	 * @param mixed
	 * @param string
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	function convertToType($value, $type);

	/**
	 * Type is taken from function annotation.
	 * Must throw InvalidArgumentException on unsupported $type.
	 *
	 * @param mixed
	 * @param string
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	function convertFromType($value, $type);

}
