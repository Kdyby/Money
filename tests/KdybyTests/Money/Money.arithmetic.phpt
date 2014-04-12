<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 123, 'Test Currency', 100);
$money = new Money(101, $currency);
$negMoney = new Money(-101, $currency);

$test = function($expected, $money) use ($currency) {
	Assert::equal(new Money($expected, $currency), $money);
};
$test(-101, $money->negated());
$test(101, $negMoney->negated());

$zero = new Money(0, $currency);
$test(0, $zero->negated());

Assert::same(1, $money->truncated());
Assert::same(-1, $negMoney->truncated());

$eleven = new Money(1140, $currency);
Assert::same(11, $eleven->truncated());
$minusEleven = new Money(-1140, $currency);
Assert::same(-11, $minusEleven->truncated());

Assert::same(1, $money->fractionPart());
Assert::same(-1, $negMoney->fractionPart());

$one = new Money(100, $currency);
Assert::same(0, $one->fractionPart());
$minusOne = new Money(-100, $currency);
Assert::same(0, $minusOne->fractionPart());
