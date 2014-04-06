<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 123, 'Test Currency', 100);

$test = function($a, $b) use ($currency) {
	$expect = new Money($a + $b, $currency);
	$money = new Money($a, $currency);
	Assert::equal($expect, $money->add(new Money($b, $currency)));
	Assert::equal($expect, $money->add($b));
	Assert::equal($expect, $money->add((string) $b));
	$money = new Money($b, $currency);
	Assert::equal($expect, $money->add(new Money($a, $currency)));
	Assert::equal($expect, $money->add($a));
	Assert::equal($expect, $money->add((string) $a));
};
$test(120, 3);
$test(123, 0);
$test(126, -3);

$testError = function($b) use ($currency) {
	$money = new Money(1, $currency);
	Assert::exception(function() use ($b, $money) {
		$money->add($b);
	}, 'Kdyby\Money\InvalidArgumentException');
	Assert::exception(function() use ($b, $money) {
		$money->add((string) $b);
	}, 'Kdyby\Money\InvalidArgumentException');
};
$testError(INF);
$testError(1.1);
$testError(-1.1);
