<?php

use Kdyby\Money\Money;
use Kdyby\Money\Currency;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


$currency = new Currency('TST', 100, 'Test Currency');

test(function () use ($currency) {
	Assert::equal(new Money(0, new \Kdyby\Money\NullCurrency()), Money::from(0));
	Assert::equal(new Money(1, new \Kdyby\Money\NullCurrency()), Money::from(1));
	Assert::equal(new Money(100, new \Kdyby\Money\NullCurrency()), Money::from(100));

	Assert::equal(new Money(100, $currency), Money::from(100, $currency));
});

test(function () use ($currency) {
	Assert::equal(new Money(0, new \Kdyby\Money\NullCurrency()), Money::fromFloat(0));
	Assert::equal(new Money(1, new \Kdyby\Money\NullCurrency()), Money::fromFloat(1.1));
	Assert::equal(new Money(1, new \Kdyby\Money\NullCurrency()), Money::fromFloat(1.4));
	Assert::equal(new Money(2, new \Kdyby\Money\NullCurrency()), Money::fromFloat(1.5));
	Assert::equal(new Money(2, new \Kdyby\Money\NullCurrency()), Money::fromFloat(1.6));
	Assert::equal(new Money(100, new \Kdyby\Money\NullCurrency()), Money::fromFloat(100));

	Assert::equal(new Money(10000, $currency), Money::fromFloat(100, $currency));
	Assert::equal(new Money(10015, $currency), Money::fromFloat(100.15, $currency));
});

test(function () use ($currency) {
	Assert::exception(function () {
		Money::from(1.1);
	}, 'Kdyby\Money\InvalidArgumentException');
});
