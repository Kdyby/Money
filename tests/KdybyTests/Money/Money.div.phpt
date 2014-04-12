<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Kdyby\Money\Math;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 123, 'Test Currency', 100);

$test = function($a, $b) use ($currency) {
	$expect = new Money(Math::truncateDivision($a, $b), $currency);
	$money = new Money($a, $currency);
	Assert::equal($expect, $money->div(new Money($b, $currency)));
	Assert::equal($expect, $money->div($b));
	Assert::equal($expect, $money->div((string) $b));
	$expect = new Money(Math::truncateDivision($b, $a), $currency);
	$money = new Money($b, $currency);
	Assert::equal($expect, $money->div(new Money($a, $currency)));
	Assert::equal($expect, $money->div($a));
	Assert::equal($expect, $money->div((string) $a));
};
$test(120, 3);
$test(123, 1);
$test(120, -3);

$testError = function($b) use ($currency) {
	$money = new Money(1, $currency);
	Assert::exception(function() use ($b, $money) {
		$money->div($b);
	}, 'Kdyby\Money\InvalidArgumentException');
	Assert::exception(function() use ($b, $money) {
		$money->div((string) $b);
	}, 'Kdyby\Money\InvalidArgumentException');
};
$testError(INF);
$testError(1.1);
$testError(-1.1);
