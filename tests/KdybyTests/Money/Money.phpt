<?php

/**
 * Test: Kdyby\Money\Money.
 *
 * @testCase KdybyTests\Money\MoneyTest
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
class MoneyTest extends Tester\TestCase
{

	public function testDecimals()
	{
		$money = new Kdyby\Money\Money(10000, Currency::get('CZK'));

		Assert::same('100', $money->getAmount());
		Assert::same('00', $money->getDecimals());
		Assert::same(Currency::get('czk'), $money->getCurrency());
		Assert::same('10000', (string) $money);
	}

}

\run(new MoneyTest());
