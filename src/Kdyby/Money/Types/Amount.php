<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money\Types;

use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use Kdyby\Money\Amount as AmountObject;



/**
 * @author Michal Gebauer <mishak@mishak.net>
 */
class Amount extends IntegerType
{

	const AMOUNT = 'amount';


	public function getName()
	{
		return self::AMOUNT;
	}


	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return ceil($value);
	}


	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		return ceil($value);
	}

}
