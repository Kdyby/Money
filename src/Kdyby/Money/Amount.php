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


class Amount extends Nette\Object
{

    /** @var string */
    private $value;


    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = (string) $value;
    }


    public function __toString()
    {
        return $this->value;
    }

}
