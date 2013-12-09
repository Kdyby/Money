<?php

namespace Kdyby\Money;

use Kdyby;
use Nette;


class MoneyComputer extends Computer
{

	/** @var ICurrency */
	private $currency;

	/** @var int */
	private $decimals;

	/** @var string */
	private $class;


	protected function convertArguments($arguments)
	{
		$this->currency = NULL;
		$converted = array();
		foreach ($arguments as $argument) {
			if ($argument instanceof Money) {
				if ($this->currency === NULL) {
					$this->currency = $argument->getCurrency();
					$this->decimals = $this->currency->getDecimals();

				} elseif ($this->currency !== $argument->getCurrency()) {
					throw new InvalidArgumentException('Arguments contain Money with different currencies.');
				}

				$this->class = get_class($argument);
				$argument = $argument->toDecimal();
			}
			$converted[] = $this->calculator->convertFromScalar($argument);
		}
		return $converted;
	}


	protected function convertToResult($value)
	{
		$result = parent::convertToResult($value);
		$class = $this->class;
		return $this->currency ? new $class($this->adjustValueToDecimals($result), $this->currency) : $result;
	}


	/**
	 * @param float|string|int
	 * @return string
	 */
	private function adjustValueToDecimals($value)
	{
		$parts = explode('.', is_string($value) ? $value : number_format($value, $this->decimals, '.', ''), 2);
		return $parts[0] . substr(str_pad(isset($parts[1]) ? $parts[1] : '', $this->decimals, '0', STR_PAD_RIGHT), 0, $this->decimals);
	}

}
