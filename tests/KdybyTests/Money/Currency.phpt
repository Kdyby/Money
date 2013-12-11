<?php

/**
 * Test: Kdyby\Money\Currency.
 *
 * @testCase KdybyTests\Money\CurrencyTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Money
 */

namespace KdybyTests\Money;

use Kdyby;
use Kdyby\Money\Currency;
use Nette;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class CurrencyTest extends Tester\TestCase
{

	public function testSingleton()
	{
		Assert::same(Currency::get('CZK'), Currency::get('CZK'));

		$refl = Nette\Reflection\ClassType::from('Kdyby\Money\Currency');
		Assert::true($refl->getMethod('__construct')->isPrivate());
		Assert::true($refl->getMethod('__construct')->isFinal());

		Assert::throws(function () {
			$clone = clone Currency::get('CZK');
		}, 'Kdyby\Money\SingletonException', 'Cloning is not allowed on this object.');

		Assert::throws(function () {
			$copy = unserialize('O:20:"Kdyby\Money\Currency":0:{}');
		}, 'Kdyby\Money\SingletonException', 'Unserialization is not allowed on this object.');

		Assert::throws(function () {
			$copy = Currency::__set_state(array());
		}, 'Kdyby\Money\SingletonException', 'Unserialization is not allowed on this object.');
	}



	public function testFloatingPointError()
	{
		$czk = Currency::get('CZK');

		Assert::same(945, $czk->scaleAmount(9.45));
		Assert::same(9.45, $czk->unscaleAmount(945.0));
	}

}

\run(new CurrencyTest());
