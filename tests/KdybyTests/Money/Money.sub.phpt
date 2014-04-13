<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');

test(function () use ($currency) {
	$test = function ($a, $b) use ($currency) {
		$expect = new Money($a - $b, $currency);
		$money = new Money($a, $currency);
		Assert::equal($expect, $money->sub(new Money($b, $currency)));
		Assert::equal($expect, $money->sub($b));
		Assert::equal($expect, $money->sub((string) $b));
		$expect = new Money($b - $a, $currency);
		$money = new Money($b, $currency);
		Assert::equal($expect, $money->sub(new Money($a, $currency)));
		Assert::equal($expect, $money->sub($a));
		Assert::equal($expect, $money->sub((string) $a));
	};
	$test(126, 3);
	$test(123, 0);
	$test(120, -3);
});

test(function () use ($currency) {
	$testError = function ($b) use ($currency) {
		$money = new Money(1, $currency);
		Assert::exception(function () use ($b, $money) {
			$money->sub($b);
		}, 'Kdyby\Money\InvalidArgumentException');
		Assert::exception(function () use ($b, $money) {
			$money->sub((string) $b);
		}, 'Kdyby\Money\InvalidArgumentException');
	};
	$testError(INF);
	$testError(1.1);
	$testError(-1.1);
});
