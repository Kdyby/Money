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
		$money = new Kdyby\Money\Money(1, Currency::get('CZK'));
		Assert::same(0, $money->getAmount());
		Assert::same(1, $money->getDecimals());
		Assert::same('1', (string) $money);

		$money = new Kdyby\Money\Money(10, Currency::get('CZK'));
		Assert::same(0, $money->getAmount());
		Assert::same(10, $money->getDecimals());
		Assert::same('10', (string) $money);

		$money = new Kdyby\Money\Money(10000, Currency::get('CZK'));
		Assert::same(100, $money->getAmount());
		Assert::same(0, $money->getDecimals());
		Assert::same(Currency::get('czk'), $money->getCurrency());
		Assert::same('10000', (string) $money);

		$money = new Kdyby\Money\Money(10010, Currency::get('CZK'));
		Assert::same(100, $money->getAmount());
		Assert::same(10, $money->getDecimals());
		Assert::same('10010', (string) $money);

		$money = new Kdyby\Money\Money(10010.0, Currency::get('CZK'));
		Assert::same(100, $money->getAmount());
		Assert::same(10, $money->getDecimals());
		Assert::same('10010', (string) $money);

		Assert::throws(function () {
			new Kdyby\Money\Money(10010.10, Currency::get('CZK'));
		}, 'Kdyby\Money\InvalidArgumentException', 'Only whole numbers are allowed, 10010.1 given.');
	}

}

\run(new MoneyTest());
