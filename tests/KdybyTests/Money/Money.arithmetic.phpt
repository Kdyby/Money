<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');
$money = new Money(101, $currency);
$negMoney = new Money(-101, $currency);

$assertMoney = function ($expected, $money) use ($currency) {
	Assert::equal(new Money($expected, $currency), $money);
};

test(function () use ($assertMoney, $money, $negMoney) {
	$assertMoney(-101, $money->negated());
	$assertMoney(101, $negMoney->negated());
});

test(function () use ($assertMoney, $currency) {
	$zero = new Money(0, $currency);
	$assertMoney(0, $zero->negated());
});

test(function () use ($money, $negMoney) {
	Assert::same(1, $money->truncated());
	Assert::same(-1, $negMoney->truncated());
});

test(function () use ($currency) {
	$eleven = new Money(1140, $currency);
	Assert::same(11, $eleven->truncated());
	$minusEleven = new Money(-1140, $currency);
	Assert::same(-11, $minusEleven->truncated());
});

test(function () use ($money, $negMoney) {
	Assert::same(1, $money->fractionPart());
	Assert::same(-1, $negMoney->fractionPart());
});

test(function () use ($currency) {
	$one = new Money(100, $currency);
	Assert::same(0, $one->fractionPart());
	$minusOne = new Money(-100, $currency);
	Assert::same(0, $minusOne->fractionPart());
});
