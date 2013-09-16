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
 * @author Michal Gebauer <mishak@mishak.net>
 */
class Money
{

    /** @var Amount */
    private $amount;

    /** @var Currency */
    private $currency;


    public function __construct(Amount $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }


    public function getAmount()
    {
        return $this->amount;
    }


    public function getCurrency()
    {
        return $this->currency;
    }

}
