<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Kdyby\Money;



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
		if ($value === NULL) {
			return NULL;
		}

		return $this->currencyProvider->findByCode($value);
	}



	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value instanceof Money\Currency) {
			$value = $value->getCode();
		}

		return $value;
	}

}
