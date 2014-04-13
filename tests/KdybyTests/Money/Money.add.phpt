<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Kdyby\Money\NullCurrency;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');

test(function () use ($currency) {
	$test = function ($a, $b) use ($currency) {
		$expect = new Money($a + $b, $currency);

		$money = new Money($a, $currency);
		Assert::equal($expect, $money->add(new Money($b, $currency)));
		Assert::equal($expect, $money->add($b));
		Assert::equal($expect, $money->add((string) $b));
		Assert::equal($expect, $money->add(Money::from($b)));
		Assert::equal($expect, $money->add(Money::from($b, new NullCurrency())));

		$money = new Money($b, $currency);
		Assert::equal($expect, $money->add(new Money($a, $currency)));
		Assert::equal($expect, $money->add($a));
		Assert::equal($expect, $money->add((string) $a));
		Assert::equal($expect, $money->add(Money::from($a)));
		Assert::equal($expect, $money->add(Money::from($a, new NullCurrency())));
	};
	$test(120, 3);
	$test(123, 0);
	$test(126, -3);
});

test(function () use ($currency) {
	$testError = function ($b) use ($currency) {
		$money = new Money(1, $currency);

		Assert::exception(function () use ($b, $money) {
			$money->add($b);
		}, 'Kdyby\Money\InvalidArgumentException');

		Assert::exception(function () use ($b, $money) {
			$money->add((string) $b);
		}, 'Kdyby\Money\InvalidArgumentException');
	};
	$testError(INF);
	$testError(1.1);
	$testError(-1.1);
});

test(function () {
	$czechMoney = Money::from(1000, $czk = new Currency('CZK', 100));
	$euMoney = Money::from(1000, $eur = new Currency('EUR', 100));

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$czechMoney->add($euMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency EUR is not compatible with CZK.');

	Assert::exception(function () use ($czechMoney, $euMoney) {
		$euMoney->add($czechMoney);
	}, 'Kdyby\Money\InvalidArgumentException', 'Currency CZK is not compatible with EUR.');
});
