<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Kdyby\Money\Math;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');

test(function () use ($currency) {
	$test = function ($value) use ($currency) {
		new Money($value, $currency);
		new Money((float) $value, $currency);
		new Money((string) $value, $currency);
	};
	$test(0);
	$test(101);
	$test(-101);
});


test(function () use ($currency) {
	$testError = function ($value) use ($currency) {
		Assert::exception(function () use ($value, $currency) {
			new Money($value, $currency);
		}, 'Kdyby\Money\InvalidArgumentException');
	};
	$testError('');
	$testError('a');
	$testError(INF);
	$testError(0.1);
	$testError(M_PI);
	$testError(array());
	$testError(new \stdClass);
	$testError(fopen('php://stdin', 'r'));
});

test(function () use ($currency) {
	$test = function ($expected, $value) use ($currency) {
		Assert::same($expected, Money::fromFloat($value, $currency)->toInt());
		Assert::same($expected, Money::fromFloat((string) $value, $currency)->toInt());
	};
	$test(0, 0);
	$test(100, 1.00);
	$test(100, 1.004);
	$test(101, 1.01);
	$test(101, 1.005);
	$test(101, 1.006);
});
