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
use Kdyby;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 *
 * @ORM\Entity()
 * @ORM\Table(name="currency_exchange_rates")
 */
class ExchangeRate extends Nette\Object
{

	/**
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Currency", inversedBy="rates", cascade={"persist"})
	 * @ORM\JoinColumn(name="currency_code", referencedColumnName="code", nullable=FALSE)
	 * @var Currency
	 */
	protected $currency;



	/**
	 * @return int
	 */
	final public function getId()
	{
		return $this->id;
	}



	/**
	 * @return Currency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

}
