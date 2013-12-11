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
use Kdyby\Money\Money;
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
			array(0.0, 0, 0, '0'),
			array(-0.0, 0, 0, '0'),
			array(1, 0, 1, '1'),
			array(-1, -0, 1, '-1'),
			array(10, 0, 10, '10'),
			array(-10, -0, 10, '-10'),
			array(10000, 100, 0, '10000'),
			array(-10000, -100, 0, '-10000'),
			array(10001, 100, 1, '10001'),
			array(-10001, -100, 1, '-10001'),
			array(10010, 100, 10, '10010'),
			array(-10010, -100, 10, '-10010'),
			array(10010.0, 100, 10, '10010'),
			array(-10010.0, -100, 10, '-10010'),
		);
	}



	/**
	 * @dataProvider dataDecimals_valid
	 */
	public function testDecimals_valid($amount, $expectedAmount, $expectedDecimals, $formatted)
	{
		$money = new Money($amount, Currency::get('CZK'));
		Assert::same($expectedAmount, $money->getAmount());
		Assert::same($expectedDecimals, $money->getDecimals());
		Assert::same($formatted, (string) $money);
	}



	/**
	 * @dataProvider dataDecimals_valid
	 */
	public function testDecimalsForStringAmount_valid($amount, $expectedAmount, $expectedDecimals, $formatted)
	{
		$money = new Money((string)$amount, Currency::get('CZK'));
		Assert::same($expectedAmount, $money->getAmount());
		Assert::same($expectedDecimals, $money->getDecimals());
		Assert::same($formatted, (string) $money);
	}



	public function testDecimals_invalid()
	{
		Assert::throws(function () {
			new Money(10010.1, Currency::get('CZK'));
		}, 'Kdyby\Money\InvalidArgumentException', 'Only whole numbers are allowed, 10010.1 given.');
	}



	public function testDecimalsForStringAmount_invalid()
	{
		Assert::throws(function () {
			new Money('10010.10', Currency::get('CZK'));
		}, 'Kdyby\Money\InvalidArgumentException', 'Only whole numbers are allowed, 10010.10 given.');
	}



	public function dataIsZero()
	{
		return array(
			array(0, TRUE),
			array(1, FALSE),
			array(10, FALSE),
			array(100, FALSE),
			array(1000, FALSE),
			array(0.0, TRUE),
			array(1.0, FALSE),
			array(10.0, FALSE),
			array(100.0, FALSE),
			array(1000.0, FALSE),
		);
	}



	/**
	 * @dataProvider dataIsZero
	 */
	public function testIsZero($amount, $expected)
	{
		$money = new Money($amount, Currency::get('CZK'));
		Assert::same($expected, $money->isZero());
	}



	/**
	 * @dataProvider dataIsZero
	 */
	public function testIsZeroForStringAmount($amount, $expected)
	{
		$money = new Money("$amount", Currency::get('CZK'));
		Assert::same($expected, $money->isZero());
	}



	public function dataEquals()
	{
		return array(
			array(0, 0, TRUE),
			array(0, 1, FALSE),
			array(1, 0, FALSE),
			array(1, 1, TRUE),
			array(10, 1, FALSE),
			array(100, 1, FALSE),
			array(1000, 1, FALSE),
			array(1010, 1, FALSE),
			array(1, 10, FALSE),
			array(10, 10, TRUE),
			array(100, 10, FALSE),
			array(1000, 10, FALSE),
			array(1010, 10, FALSE),
			array(1, 100, FALSE),
			array(10, 100, FALSE),
			array(100, 100, TRUE),
			array(1000, 100, FALSE),
			array(1010, 100, FALSE),
			array(1, 1000, FALSE),
			array(10, 1000, FALSE),
			array(100, 1000, FALSE),
			array(1000, 1000, TRUE),
			array(1010, 1000, FALSE),
			array(1, 1010, FALSE),
			array(10, 1010, FALSE),
			array(100, 1010, FALSE),
			array(1000, 1010, FALSE),
			array(1010, 1010, TRUE),
		);
	}



	/**
	 * @dataProvider dataEquals
	 */
	public function testEquals($a, $b, $expected)
	{
		$a = new Money($a, Currency::get('CZK'));

		Assert::same($expected, $a->equals(new Money($b, Currency::get('CZK'))));
		Assert::same($expected, $a->equals($b));
	}



	public function dataLargerThan()
	{
		return array(
			array(0, 0, FALSE),
			array(0, 1, FALSE),
			array(1, 0, TRUE),
			array(1, 1, FALSE),
			array(10, 1, TRUE),
			array(100, 1, TRUE),
			array(1000, 1, TRUE),
			array(1010, 1, TRUE),
			array(1, 10, FALSE),
			array(10, 10, FALSE),
			array(100, 10, TRUE),
			array(1000, 10, TRUE),
			array(1010, 10, TRUE),
			array(1, 100, FALSE),
			array(10, 100, FALSE),
			array(100, 100, FALSE),
			array(1000, 100, TRUE),
			array(1010, 100, TRUE),
			array(1, 1000, FALSE),
			array(10, 1000, FALSE),
			array(100, 1000, FALSE),
			array(1000, 1000, FALSE),
			array(1010, 1000, TRUE),
			array(1, 1010, FALSE),
			array(10, 1010, FALSE),
			array(100, 1010, FALSE),
			array(1000, 1010, FALSE),
			array(1010, 1010, FALSE),
		);
	}



	/**
	 * @dataProvider dataLargerThan
	 */
	public function testLargerThan($a, $b, $expected)
	{
		$a = new Money($a, Currency::get('CZK'));

		Assert::same($expected, $a->largerThan(new Money($b, Currency::get('CZK'))));
		Assert::same($expected, $a->largerThan($b));
	}



	public function dataLargerOrEquals()
	{
		return array(
			array(0, 0, TRUE),
			array(0, 1, FALSE),
			array(1, 0, TRUE),
			array(1, 1, TRUE),
			array(10, 1, TRUE),
			array(100, 1, TRUE),
			array(1000, 1, TRUE),
			array(1010, 1, TRUE),
			array(1, 10, FALSE),
			array(10, 10, TRUE),
			array(100, 10, TRUE),
			array(1000, 10, TRUE),
			array(1010, 10, TRUE),
			array(1, 100, FALSE),
			array(10, 100, FALSE),
			array(100, 100, TRUE),
			array(1000, 100, TRUE),
			array(1010, 100, TRUE),
			array(1, 1000, FALSE),
			array(10, 1000, FALSE),
			array(100, 1000, FALSE),
			array(1000, 1000, TRUE),
			array(1010, 1000, TRUE),
			array(1, 1010, FALSE),
			array(10, 1010, FALSE),
			array(100, 1010, FALSE),
			array(1000, 1010, FALSE),
			array(1010, 1010, TRUE),
		);
	}



	/**
	 * @dataProvider dataLargerOrEquals
	 */
	public function testLargerOrEquals($a, $b, $expected)
	{
		$a = new Money($a, Currency::get('CZK'));

		Assert::same($expected, $a->largerOrEquals(new Money($b, Currency::get('CZK'))));
		Assert::same($expected, $a->largerOrEquals($b));
	}



	public function testFloatingPointError()
	{
		$money = new Money(9.45 * 100, Currency::get('CZK'));
		Assert::same(9, $money->getAmount());
		Assert::same(45, $money->getDecimals());
		Assert::same('945', (string) $money);
	}



	public function testCurrencyConflictExceptions()
	{
		$czk = new Money(10000, Currency::get('CZK'));
		$eur = new Money(10000, Currency::get('EUR'));

		Assert::throws(function () use ($czk, $eur) {
			$czk->add($eur);
		}, 'Kdyby\Money\InvalidArgumentException', 'Given value has currency EUR, but CZK was expected. To operate on these two objects, use currency table and convert the value first.');

		Assert::throws(function () use ($czk, $eur) {
			$czk->sub($eur);
		}, 'Kdyby\Money\InvalidArgumentException', 'Given value has currency EUR, but CZK was expected. To operate on these two objects, use currency table and convert the value first.');

		Assert::throws(function () use ($czk, $eur) {
			$czk->equals($eur);
		}, 'Kdyby\Money\InvalidArgumentException', 'Given value has currency EUR, but CZK was expected. To operate on these two objects, use currency table and convert the value first.');

		Assert::throws(function () use ($czk, $eur) {
			$czk->largerThan($eur);
		}, 'Kdyby\Money\InvalidArgumentException', 'Given value has currency EUR, but CZK was expected. To operate on these two objects, use currency table and convert the value first.');

		Assert::throws(function () use ($czk, $eur) {
			$czk->largerOrEquals($eur);
		}, 'Kdyby\Money\InvalidArgumentException', 'Given value has currency EUR, but CZK was expected. To operate on these two objects, use currency table and convert the value first.');

		Assert::throws(function () use ($czk, $eur) {
			new Money(new Money(10000, Currency::get('EUR')), Currency::get('CZK'));
		}, 'Kdyby\Money\InvalidArgumentException', 'Given value has currency EUR, but CZK was expected. To operate on these two objects, use currency table and convert the value first.');
	}

}

\run(new MoneyTest());
