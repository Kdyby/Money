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
				$argument = $this->moneyValueToString($argument->__toString());
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


	/**
	 * @param string
	 * @return string
	 */
	private function moneyValueToString($value)
	{
		if ($negative = ($value[0] === '-')) {
			$value = substr($value, 1);
		}

		$decimals = rtrim(substr(str_pad($value, $this->decimals, '0', STR_PAD_LEFT), -$this->decimals), '0');
		return ($negative ? '-' : '') . (substr($value, 0, -$this->decimals) ?: '0') . ($decimals ? '.' . $decimals : '');
	}


	/**
	 * @deprecated
	 */
	public static function getInstance()
	{
		static $instance = NULL;
		if ($instance === NULL) {
			return $instance = new static;
		}

		return $instance;
	}

}
