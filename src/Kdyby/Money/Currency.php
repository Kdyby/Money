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
 * @property-read string $code
 * @property-read string $number
 * @property-read string $name
 * @property-read int $subunitsInUnit
 * @property-read string[] $countries
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
	private $subunitsInUnit;

	/**
	 * @var string[]
	 */
	private $countries;



	/**
	 * @param string $code
	 * @param string $number
	 * @param string $name
	 * @param string $subunitsInUnit
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

}
