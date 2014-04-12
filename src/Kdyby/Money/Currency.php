<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money;

use Doctrine\ORM\Mapping as ORM;
use Nette;



/**
 * @author Michal Gebauer <mishak@mishak.net>
 * @author Filip Procházka <filip@prochazka.su>
 * @author Ladislav Marek <ladislav@marek.su>
 *
 * @ORM\Entity()
 * @ORM\Table(name="currencies")
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
	 * @ORM\Id()
	 * @ORM\Column(type="string", length=15)
	 * @var string
	 */
	private $code;

	/**
	 * @ORM\Column(type="string", length=15, columnDefinition="CHAR(5) NOT NULL")
	 * @var string
	 */
	private $number;

	/**
	 * @ORM\Column(type="string", length=100)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\Column(type="integer", name="subunits_in_unit", length=3)
	 * @var int
	 */
	private $subunitsInUnit;

	/**
	 * @ORM\Column(type="json_array")
	 * @var string[]
	 */
	private $countries;



	/**
	 * @param string $code
	 * @param string $number
	 * @param string $name
	 * @param int $subunitsInUnit
	 * @param array $countries
	 */
	public function __construct($code, $number, $name, $subunitsInUnit = 100, array $countries = array())
	{
		$this->code = $code;
		$this->number = $number;
		$this->name = $name;
		$this->subunitsInUnit = $subunitsInUnit;
		$this->countries = $countries;
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
			: $currencies[$code] = new static($record['code'], $record['number'], $record['name'], $record['decimals'], $record['countries']);
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
