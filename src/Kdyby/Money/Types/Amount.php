<?php

namespace Kdyby\Money\Types;

use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Kdyby\Money\Amount as AmountObject;


class Amount extends DecimalType
{

    const AMOUNT = 'amount';

    /**
     * Most currencies have 2 decimal places few have 3 as of 2013-04-09
     */
    const DEFAULT_SCALE = 2;

    /**
     * Value is based on US budget that was in trillions for last two decades
     * so even for hi-end shopping it should be safe
     */
    const DEFAULT_PRECISION = 16;


    public function getName()
    {
        return self::AMOUNT;
    }


    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return parent::getSqlDeclaration($fieldDeclaration + array(
            'precision' => self::DEFAULT_PRECISION,
            'scale' => self::DEFAULT_SCALE,
        ), $platform);
    }


    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new AmountObject($value);
    }


    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof AmountObject) {
            $value = $value->__toString();
        }

        return $value;
    }

}
