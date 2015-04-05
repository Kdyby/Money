<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money;

use Doctrine\Common\Collections\ArrayCollection;
use Nette;



/**
 * @author Michal Gebauer <mishak@mishak.net>
 * @author Filip Procházka <filip@prochazka.su>
 * @author Ladislav Marek <ladislav@marek.su>
 *
 * @property-read string $code
 * @property-read string $number
 * @property-read string $name
 * @property-read int $subunitsInUnit
 * @property-read string[] $countries
 */
class Currency extends Nette\Object implements ICurrency
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
	private $subunitsInUnit;

	/**
	 * @var string[]
	 */
	private $countries;

	/**
	 * @var ExchangeRate
	 */
	protected $rates;



	/**
	 * @param string $code
	 * @param int $subunitsInUnit
	 * @param string $name
	 * @param string $number
	 * @param array $countries
	 */
	public function __construct($code, $subunitsInUnit = 100, $name = NULL, $number = NULL, array $countries = array())
	{
		$this->code = $code;
		$this->subunitsInUnit = $subunitsInUnit;
		$this->name = $name ?: $code;
		$this->number = $number ?: '000';
		$this->countries = $countries;
		$this->rates = new ArrayCollection();
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
	public function getSubunitsInUnit()
	{
		return $this->subunitsInUnit;
	}



	/**
	 * @return string[]
	 */
	public function getCountries()
	{
		return $this->countries;
	}



	/**
	 * @return int
	 */
	public function computePrecision()
	{
		return Math::floorLog($this->subunitsInUnit, 10);
	}



	public function isInterchangeable(Currency $currency)
	{
		return $this === $currency
			|| ( // for BC
				$this->code === $currency->code
				&& $this->number === $currency->number
				&& $this->subunitsInUnit === $currency->subunitsInUnit
			);
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->code;
	}


	/**
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}



	/**
	 * @deprecated
	 * @return int
	 */
	public function getDecimals()
	{
		return $this->computePrecision();
	}



	/**
	 * @deprecated
	 * @return Currency
	 */
	public static function get($code)
	{
		static $currencies = array();

		$record = CurrencyTable::getRecord($code);
		return isset($currencies[$code])
			? $currencies[$code]
			: $currencies[$code] = new static($record['code'], $record['decimals'], $record['name'], $record['number'], $record['countries']);
	}



	/**
	 * @deprecated
	 */
	public function scaleAmount($amount)
	{
		return (int) round($amount * $this->getSubunitsInUnit(), 10);
	}



	/**
	 * @deprecated
	 */
	public function unscaleAmount($amount)
	{
		return $amount / $this->getSubunitsInUnit();
	}

}
