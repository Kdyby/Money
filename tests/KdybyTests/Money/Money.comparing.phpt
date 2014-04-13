<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Kdyby\Money\Math;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');

test(function () use ($currency) {
	$test = function ($a, $b) use ($currency) {
		foreach (array(array(-1, 1), array(1, 1), array(1, -1)) as $neg) {
			list($negA, $negB) = $neg;

			$tmpA = $a * $negA;
			$tmpB = $b * $negB;

			$moneyA = new Money($tmpA, $currency);
			$moneyB = new Money($tmpB, $currency);

			Assert::same($tmpA === $tmpB, $moneyA->equals($moneyB));
			Assert::same($tmpB === $tmpA, $moneyB->equals($moneyA));

			Assert::same($tmpA < $tmpB, $moneyA->lessThan($moneyB));
			Assert::same($tmpB < $tmpA, $moneyB->lessThan($moneyA));

			Assert::same($tmpA > $tmpB, $moneyA->largerThan($moneyB));
			Assert::same($tmpB > $tmpA, $moneyB->largerThan($moneyA));

			Assert::same($tmpA <= $tmpB, $moneyA->lessOrEquals($moneyB));
			Assert::same($tmpB <= $tmpA, $moneyB->lessOrEquals($moneyA));

			Assert::same($tmpA >= $tmpB, $moneyA->largerOrEquals($moneyB));
			Assert::same($tmpB >= $tmpA, $moneyB->largerOrEquals($moneyA));

			Assert::equal(new Money(max($tmpA, $tmpB), $currency), $moneyA->max($moneyB));
			Assert::equal(new Money(max($tmpA, $tmpB), $currency), $moneyB->max($moneyA));

			Assert::equal(new Money(min($tmpA, $tmpB), $currency), $moneyA->min($moneyB));
			Assert::equal(new Money(min($tmpA, $tmpB), $currency), $moneyB->min($moneyA));
		}
	};

	$test(0, 0);
	$test(101, 0);
	$test(101, 50);
});

test(function () use ($currency) {
	$zero = new Money(0, $currency);
	Assert::true($zero->isZero());
	$one = new Money(100, $currency);
	Assert::false($one->isZero());
	$minusOne = new Money(-100, $currency);
	Assert::false($minusOne->isZero());
});


test(function () {
	$czechMoney = Money::from(1000, $czk = new Currency('CZK', 100));
	$euMoney = Money::from(1000, $eur = new Currency('EUR', 100));

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$czechMoney->equals($euMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency EUR is not compatible with CZK.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$euMoney->equals($czechMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency CZK is not compatible with EUR.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$czechMoney->lessThan($euMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency EUR is not compatible with CZK.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$euMoney->lessThan($czechMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency CZK is not compatible with EUR.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$czechMoney->largerThan($euMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency EUR is not compatible with CZK.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$euMoney->largerThan($czechMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency CZK is not compatible with EUR.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$czechMoney->lessOrEquals($euMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency EUR is not compatible with CZK.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$euMoney->lessOrEquals($czechMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency CZK is not compatible with EUR.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$czechMoney->largerOrEquals($euMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency EUR is not compatible with CZK.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$euMoney->largerOrEquals($czechMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency CZK is not compatible with EUR.');
});
