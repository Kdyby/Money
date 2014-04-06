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



class CurrencyTable extends Nette\Object
{

	public $currencies = [];



	public function add(Currency $currency)
	{
		$this->currencies[$currency->getCode()] = $currency;
	}



	public function createMoney($amount, $currencyCode)
	{
		return new Money($amount, $this->getByCode($currencyCode));
	}



	public function findByCode($code)
	{
		if (!isset($this->currencies[$code])) {
			$this->cannotFoundCurrency($code);
		}
		return $this->currencies[$code];
	}



	public function cannotFoundCurrency($code)
	{
		throw new InvalidArgumentException;
	}

}
