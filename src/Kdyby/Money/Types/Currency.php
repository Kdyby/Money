<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Kdyby\Money\Currency as CurrencyObject;



/**
 * @author Michal Gebauer <mishak@mishak.net>
 */
class Currency extends Type
{

    const CURRENCY = 'currency';


    public function getName()
    {
        return self::CURRENCY;
    }


    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(array(
            'length' => 3,
            'fixed' => TRUE,
        ));
    }


    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return CurrencyObject::get($value);
    }


    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof CurrencyObject) {
            $value = $value->getCode();
        }

        return $value;
    }

}
