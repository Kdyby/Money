<?php

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
