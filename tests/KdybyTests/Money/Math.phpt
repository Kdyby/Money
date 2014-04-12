<?php

use Kdyby\Money\Math;
use Kdyby\Money\InvalidArgumentException;

require_once __DIR__ . '/../bootstrap.php';


Assert::exception(function() {
	Math::parseInt(100.1);
}, 'Kdyby\Money\InvalidArgumentException', 'Provided value cannot be converted to integer');

Assert::exception(function() {
	Math::parseInt(-100.1);
}, 'Kdyby\Money\InvalidArgumentException', 'Provided value cannot be converted to integer');

Assert::exception(function() {
	Math::parseInt('100.1');
}, 'Kdyby\Money\InvalidArgumentException', 'Provided value cannot be converted to integer');

Assert::exception(function() {
	Math::parseInt('-100.1');
}, 'Kdyby\Money\InvalidArgumentException', 'Provided value cannot be converted to integer');

Assert::exception(function() {
	Math::parseInt(INF);
}, 'Kdyby\Money\InvalidArgumentException', 'Provided value cannot be converted to integer');

Assert::exception(function() {
	Math::parseInt(-INF);
}, 'Kdyby\Money\InvalidArgumentException', 'Provided value cannot be converted to integer');

Assert::same(100, Math::parseInt((float) 100));
Assert::same(-100, Math::parseInt((float) -100));
Assert::same(100, Math::parseInt('100'));
Assert::same(-100, Math::parseInt('-100'));

Assert::same(2, Math::quotient(5, 2));
Assert::same(-2, Math::quotient(-5, 2));
Assert::same(-2, Math::quotient(5, -2));
Assert::same(2, Math::quotient(-5, -2));
Assert::same(0, Math::quotient(5, 10));
Assert::same(0, Math::quotient(-5, 10));

Assert::same(2, Math::truncateDivision(5, 2));
Assert::same(-3, Math::truncateDivision(-5, 2));
Assert::same(-3, Math::truncateDivision(5, -2));
Assert::same(2, Math::truncateDivision(-5, -2));
Assert::same(0, Math::truncateDivision(5, 10));
Assert::same(-1, Math::truncateDivision(-5, 10));
