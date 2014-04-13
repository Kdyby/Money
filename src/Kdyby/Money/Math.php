<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money;



/**
 * @author Ladislav Marek
 */
final class Math
{

	public function __construct()
	{
		throw new ClassNotInstantiableException();
	}



	public function __unserialize()
	{
		throw new ClassNotInstantiableException();
	}



	/**
	 * @param string|float|int $s
	 * @throws InvalidArgumentException
	 * @return int
	 */
	public static function parseInt($s)
	{
		if (!is_numeric($s) || round($s) !== (float) $s || is_infinite($s)) {
			throw new InvalidArgumentException('Provided value cannot be converted to integer');
		}
		return (int) $s;
	}



	/**
	 * @param string|float|int
	 * @throws InvalidArgumentException
	 * @return float|int
	 */
	public static function parseNumber($s)
	{
		if (!is_numeric($s) || is_infinite($s)) {
			throw new InvalidArgumentException('Provided value cannot be converted to number');
		}
		return $s * 1;
	}



	/**
	 * Quotient defined by division with truncation toward zero.
	 * @param int $int
	 * @param int $divisor
	 * @throws InvalidArgumentException
	 * @return int
	 */
	public static function quotient($int, $divisor)
	{
		if ($divisor === 0) {
			throw new InvalidArgumentException('Division by zero');
		}
		return (int) ($int / $divisor);
	}



	/**
	 * Quotient defined by division with truncation toward negative infinity.
	 * @param int $int
	 * @param int $divisor
	 * @throws InvalidArgumentException
	 * @return int
	 */
	public static function truncateDivision($int, $divisor)
	{
		if ($divisor === 0) {
			throw new InvalidArgumentException('Division by zero');
		}
		return (int) floor($int / $divisor);
	}



	/**
	 * @param int $int
	 * @param int $base
	 * @throws InvalidArgumentException
	 * @return float
	 */
	public static function floorLog($int, $base)
	{
		if ($base <= 0) {
			throw new InvalidArgumentException('Base must be greater than 0');
		}
		return floor(log($int, $base));
	}

}
