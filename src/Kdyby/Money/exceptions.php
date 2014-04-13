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
 * @author Filip Procházka <filip@prochazka.su>
 */
interface Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class InvalidStateException extends \RuntimeException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ClassNotInstantiableException extends \LogicException implements Exception
{

}



/**
 * The exception that is thrown when an invoked method is not supported. For scenarios where
 * it is sometimes possible to perform the requested operation, see InvalidStateException.
 */
class NotSupportedException extends \LogicException implements Exception
{

}



/**
 * The exception that is thrown when a requested method or operation is deprecated.
 */
class DeprecatedException extends NotSupportedException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class MetadataException extends \LogicException implements Exception
{

	public static function missingCurrencyReference(\ReflectionProperty $refl)
	{
		$property = $refl->getDeclaringClass()->getName() . '::$' . $refl->getName();
		return new static("Property $property of type Money is missing reference to currency field. You can specify it using @ORM\\Column(options={\"currency\":\"fieldName\"})");
	}



	public static function invalidCurrencyReference(\ReflectionProperty $refl)
	{
		$property = $refl->getDeclaringClass()->getName() . '::$' . $refl->getName();
		return new static("Property $property of type Money has invalid currency reference in it's Column options. It must be a valid association to " . Currency::getClassName() . " entity.");
	}

}
