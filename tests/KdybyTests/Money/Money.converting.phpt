<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Kdyby\Money\Math;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');

test(function () use ($currency) {
	$test = function ($value, $float, $string, $formatted) use ($currency) {
		$money = new Money($value, $currency);
		Assert::same($value, $money->toInt());
		Assert::equal($float, $money->toFloat());
		// Assert::same($string, (string) $money);
		Assert::same($formatted, $money->format('%1$d %2$s %3$s %4$s'));
	};

	//$test(-101, -1.01, '-1.01 TST', '-1 01 TST Test Currency');
	//$test(0, 0.0, '0.00 TST', '0 00 TST Test Currency');
	//$test(101, 1.01, '1.01 TST', '1 01 TST Test Currency');

	$test(-101, -1.01, '-1.01', '-1 01 TST Test Currency');
	$test(0, 0.0, '0.00', '0 00 TST Test Currency');
	$test(101, 1.01, '1.01', '1 01 TST Test Currency');
});
