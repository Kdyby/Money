<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');

test(function () use ($currency) {
	$test = function ($a, $b) use ($currency) {
		$expect = new Money($a * $b, $currency);
		$money = new Money($a, $currency);
		Assert::equal($expect, $money->mul(new Money($b, $currency)));
		Assert::equal($expect, $money->mul($b));
		Assert::equal($expect, $money->mul((string) $b));
		$money = new Money($b, $currency);
		Assert::equal($expect, $money->mul(new Money($a, $currency)));
		Assert::equal($expect, $money->mul($a));
		Assert::equal($expect, $money->mul((string) $a));
	};
	$test(120, 3);
	$test(123, 0);
	$test(120, -3);
});

test(function () use ($currency) {
	$test = function ($b) use ($currency) {
		$expect = new Money(round($b), $currency);
		$money = new Money(1, $currency);
		Assert::equal($expect, $money->mul($b));
		Assert::equal($expect, $money->mul((string) $b));
	};
	$test(1.1);
	$test(-1.1);

	$testError = function ($b) use ($currency) {
		$money = new Money(1, $currency);
		Assert::exception(function () use ($b, $money) {
			$money->mul($b);
		}, 'Kdyby\Money\InvalidArgumentException');
		Assert::exception(function () use ($b, $money) {
			$money->mul((string) $b);
		}, 'Kdyby\Money\InvalidArgumentException');
	};
	$testError(INF);
	$testError(-INF);
});

test(function () {
	$czechMoney = Money::from(1000, $czk = new Currency('CZK', 100));
	$euMoney = Money::from(1000, $eur = new Currency('EUR', 100));

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$czechMoney->mul($euMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency EUR is not compatible with CZK.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$euMoney->mul($czechMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency CZK is not compatible with EUR.');
});
