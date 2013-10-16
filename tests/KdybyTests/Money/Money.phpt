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

	public function dataDecimals_valid()
	{
		return array(
			array(1, 0, 1, '1'),
			array(10, 0, 10, '10'),
			array(10000, 100, 0, '10000'),
			array(10010, 100, 10, '10010'),
			array(10010.0, 100, 10, '10010'),
		);
	}



	/**
	 * @dataProvider dataDecimals_valid
	 */
	public function testDecimals_valid($amount, $expectedAmount, $expectedDecimals, $formatted)
	{
		$money = new Kdyby\Money\Money($amount, Currency::get('CZK'));
		Assert::same($expectedAmount, $money->getAmount());
		Assert::same($expectedDecimals, $money->getDecimals());
		Assert::same($formatted, (string) $money);
	}



	public function testDecimals_invalid()
	{
		Assert::throws(function () {
			new Kdyby\Money\Money(10010.10, Currency::get('CZK'));
		}, 'Kdyby\Money\InvalidArgumentException', 'Only whole numbers are allowed, 10010.1 given.');
	}

}

\run(new MoneyTest());
