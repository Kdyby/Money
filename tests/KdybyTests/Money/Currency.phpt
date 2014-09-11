<?php

use Kdyby\Money\Currency;

require_once __DIR__ . '/../bootstrap.php';




test(function() {
	$currency = new Currency('TST', 100, 'Test Currency');
	Assert::equal(727, $currency->scaleAmount(7.268));
	Assert::equal(726, $currency->scaleAmount(7.262));
	Assert::equal(720, $currency->scaleAmount(7.2));
	Assert::equal(700, $currency->scaleAmount(7));
});