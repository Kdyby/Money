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
	public $money;

	/**
	 * @ORM\ManyToOne(targetEntity="\Kdyby\Money\Currency", cascade={"persist"})
	 * @var Currency
	 */
	public $obscureNamedCurrencyField;



	public function __construct($money, $currency)
	{
		$this->money = $money;
		$this->obscureNamedCurrencyField = $currency instanceof Currency ? $currency : new Currency($currency, '123', 'Testing currency');
	}

}

