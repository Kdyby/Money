<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money {

	/**
	 * @deprecated
	 */
	final class CurrencyTable
	{

		const VERSION = '2013-11-07';


		private static $records = array();



		private function __construct()
		{
			// cannot be instantiated
		}



		/**
		 * @deprecated
		 * @return array|NULL
		 */
		public static function getRecord($code)
		{
			if (!isset(self::$records[$code])) {
				self::$records[$code] = array(
					'number' => '666',
					'code' => $code,
					'name' => $code,
					'decimals' => 100,
					'countries' => array('Republic of Mars'),
				);
			}

			return self::$records[$code];
		}



		/**
		 * @deprecated
		 */
		public static function registerRecord($code, array $details)
		{
			$code = strtoupper($code);
			if ($details['decimals'] < 10) {
				$details['decimals'] = pow(10, $details['decimals']);
			}
			self::$records[$code] = array('code' => $code) + $details + self::getRecord($code);
		}

	}



	/**
	 * @deprecated
	 */
	interface ICurrency
	{

		/**
		 * @deprecated
		 */
		function getCode();



		/**
		 * @deprecated
		 */
		function scaleAmount($amount);



		/**
		 * @deprecated
		 */
		function unscaleAmount($amount);

	}



	/**
	 * @deprecated
	 */
	abstract class Exchanger
	{


		/**
		 * @deprecated
		 */
		public function convert(Money $money, ICurrency $to)
		{
			$amount = $money->toFloat() * $this->calculateExchangeRate($money->getCurrency(), $to);
			return new $money($to->scaleAmount($amount), $to);
		}



		/**
		 * @deprecated
		 */
		public function calculateExchangeRate(ICurrency $from, ICurrency $to)
		{
			$fromRate = (float) $this->getRate($from) ? : 1.0;
			$toRate = (float) $this->getRate($to) ? : 1.0;

			return $fromRate / $toRate;
		}



		/**
		 * @deprecated
		 */
		abstract public function getRate(ICurrency $currency);

	}

}

namespace Kdyby\Money\DI {

	use Kdyby\Money\DeprecatedException;
	use Nette\DI\CompilerExtension;


	if (!class_exists('Nette\DI\CompilerExtension')) {
		eval('namespace Nette\DI { class CompilerExtension {} }');
	}

	class MoneyExtension extends CompilerExtension
	{

		public function __construct()
		{
			throw new DeprecatedException(
				"If you wanna use this exception, install https://packagist.org/packages/kdyby/doctrine-money. " .
				"This compiler extension was renamed to Kdyby\\DoctrineMoney\\DI\\MoneyExtension."
			);
		}
	}

}


namespace Kdyby\Money\Exchange {

	use Kdyby\Money\Exchanger;
	use Kdyby\Money\ICurrency;
	use Kdyby\Money\Currency;



	/**
	 * @deprecated
	 */
	class StaticExchanger extends Exchanger
	{

		/**
		 * @var array
		 */
		private $rates;



		/**
		 * @deprecated
		 */
		public function __construct(array $rates)
		{
			foreach ($rates as $code => $rate) {
				$this->rates[Currency::get($code)->getCode()] = $rate;
			}
		}



		/**
		 * @deprecated
		 */
		public function getRate(ICurrency $currency)
		{
			return (float) $this->rates[$currency->getCode()];
		}

	}

}


namespace Kdyby\Money\Types {

	use Doctrine\DBAL\Platforms\AbstractPlatform;
	use Doctrine\DBAL\Types\IntegerType;
	use Doctrine\DBAL\Types\Type;


	if (!class_exists('Doctrine\DBAL\Types\IntegerType')) {
		eval('namespace Doctrine\DBAL\Types { class IntegerType {} }');
	}

	/**
	 * @deprecated
	 */
	class Amount extends IntegerType
	{

		const AMOUNT = 'amount';


		/**
		 * @deprecated
		 */
		public function getName()
		{
			return self::AMOUNT;
		}



		/**
		 * @deprecated
		 */
		public function convertToPHPValue($value, AbstractPlatform $platform)
		{
			return ceil($value);
		}



		/**
		 * @deprecated
		 */
		public function convertToDatabaseValue($value, AbstractPlatform $platform)
		{
			return ceil($value);
		}

	}



	if (!class_exists('Doctrine\DBAL\Types\Type')) {
		eval('namespace Doctrine\DBAL\Types { class Type {} }');
	}

	/**
	 * @deprecated
	 */
	class Currency extends Type
	{

		const CURRENCY = 'currency';


		/**
		 * @deprecated
		 */
		public function getName()
		{
			return self::CURRENCY;
		}



		/**
		 * @deprecated
		 */
		public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
		{
			return $platform->getVarcharTypeDeclarationSQL(array(
				'length' => 3,
				'fixed' => TRUE,
			));
		}



		/**
		 * @deprecated
		 */
		public function convertToPHPValue($value, AbstractPlatform $platform)
		{
			if ($value === NULL) {
				return NULL;
			}

			return \Kdyby\Money\Currency::get($value);
		}



		/**
		 * @deprecated
		 */
		public function convertToDatabaseValue($value, AbstractPlatform $platform)
		{
			if ($value instanceof \Kdyby\Money\Currency) {
				$value = $value->getCode();
			}

			return $value;
		}

	}

}
