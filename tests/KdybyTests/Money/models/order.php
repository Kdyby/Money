<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace KdybyTests\Money;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Money\Currency;
use Kdyby\Money\Money;



/**
 * @ORM\Entity()
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *    "order" = "OrderEntity",
 *    "specific" = "SpecificOrderEntity",
 * })
 */
class OrderEntity extends BaseEntity
{

	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	public $id;

	/**
	 * @ORM\Column(type="money", options={"currency":"obscureNamedCurrencyField"})
	 * @var Money
	 */
	private $money;

	/**
	 * @ORM\ManyToOne(targetEntity="\Kdyby\Money\Currency", cascade={"persist"})
	 * @var Currency
	 */
	public $obscureNamedCurrencyField;



	public function __construct($money = 0, $currency = NULL)
	{
		$this->money = $money;

		if ($currency !== NULL) {
			$this->obscureNamedCurrencyField = $currency instanceof Currency
				? $currency : new Currency($currency, 100, 'Testing currency');
		}
	}



	public function getMoney()
	{
		return $this->money;
	}

}



/**
 * @ORM\Entity()
 */
class SpecificOrderEntity extends OrderEntity
{

}

