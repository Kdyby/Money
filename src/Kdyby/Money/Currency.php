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
 * @author Filip Procházka <filip@prochazka.su>
 * @author Ladislav Marek <ladislav@marek.su>
 *
 * @property-read int $decimals
 * @property-read string $name
 * @property-read string $number
 * @property-read string $code
 */
final class Currency extends Nette\Object
{

	/**
	 * @var string
	 */
	private $code;

	/**
	 * @var string
	 */
	private $number;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var int
	 */
	private $decimals;

	/**
	 * @var string[]
	 */
	private $countries;

	/**
	 * @var Currency[]
	 */
	private static $currencies = array();



	/**
	 * @param array $record Record from CurrencyTable (code, number, name, decimals, countries)
	 */
	final private function __construct($record)
	{
		$this->code = $record['code'];
		$this->number = $record['number'];
		$this->name = $record['name'];
		$this->decimals = $record['decimals'];
		$this->countries = $record['countries'];
	}



	/**
	 * @return string
	 */
	public function getCode()
	{
		return $this->code;
	}



	/**
	 * @return string
	 */
	public function getNumber()
	{
		return $this->number;
	}



	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}



	/**
	 * @return int
	 */
	public function getDecimals()
	{
		return $this->decimals;
	}



	/**
	 * @return int
	 */
	public function getScale()
	{
		return pow(10, $this->decimals);
	}



	/**
	 * @return string[]
	 */
	public function getCountries()
	{
		return $this->countries;
	}



	/**
	 * @param string $code 3 letter ISO 4217 code
	 * @throws InvalidArgumentException
	 * @return Currency
	 */
	public static function get($code)
	{
		if (isset(static::$currencies[$code = strtoupper($code)])) {
			return static::$currencies[$code];
		}

		if (($record = CurrencyTable::getRecord($code)) === NULL) {
			throw new InvalidArgumentException("Currency code '$code' is not in a CurrencyTable.");
		}

		return static::$currencies[$code] = new static($record);
	}



	/**
	 * @param  int
	 * @return int
	 */
	public function scaleAmount($amount)
	{
		return (int) round($amount * $this->getScale(), 10);
	}



	/**
	 * @param  int
	 * @return float
	 */
	public function unscaleAmount($amount)
	{
		return $amount / $this->getScale();
	}



	/**
	 * @throws SingletonException
	 */
	public function __clone()
	{
		throw new SingletonException("Cloning is not allowed on this object.");
	}



	/**
	 * @throws SingletonException
	 */
	public function __wakeup()
	{
		throw new SingletonException("Unserialization is not allowed on this object.");
	}



	/**
	 * @throws SingletonException
	 */
	public static function __set_state($an_array)
	{
		throw new SingletonException("Unserialization is not allowed on this object.");
	}

}
