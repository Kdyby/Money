<?php

namespace Kdyby\Money;

use Kdyby;
use Nette;


/**
 * @method mixed add(mixed $a, mixed $b)
 * @method mixed subtract(mixed $a, mixed $b)
 * @method mixed multiply(mixed $a, mixed $b)
 * @method mixed divide(mixed $a, mixed $b)
 */
class Computer extends Nette\Object
{

	/** @var ICalculator */
	private $calculator;

	/** @var IComparator */
	private $comparator;

	/** @var array */
	private $operations = array(
		'add',
		'subtract',
		'multiply',
		'divide',
	);


	public function __construct(ICalculator $calculator, IComparator $comparator = NULL)
	{
		if ($comparator === NULL && !$calculator instanceof IComparator) {
			throw new InvalidArgumentException('Please provide valid comparator.');
		}
		$this->calculator = $calculator;
		$this->comparator = $comparator === NULL ? $calculator : $comparator;
	}


	public function __call($name, $arguments)
	{
		if (in_array($name, $this->operations, TRUE)) {
			$result = call_user_func_array(array($this->calculator, $name), $this->convertArguments($arguments));
			return $this->calculator->convertToScalar($result);

		} else {
			return parent::__call($name, $arguments);
		}
	}


	private function convertArguments($arguments)
	{
		$converted = array();
		foreach ($arguments as $argument) {
			$converted[] = $this->calculator->convertFromScalar($argument);
		}
		return $converted;
	}

}
