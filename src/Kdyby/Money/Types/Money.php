<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use Kdyby\Money\Integer;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class Money extends IntegerType
{

	const MONEY = 'money';


	public function getName()
	{
		return self::MONEY;
	}



	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return $value;
	}



	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value instanceof Integer) {
			return $value->toInt();
		}

		return $value;
	}

}
