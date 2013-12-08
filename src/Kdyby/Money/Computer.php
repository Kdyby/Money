<?php

namespace Kdyby\Money;

use Kdyby;
use Nette;


/**
 * @method mixed add(mixed $a, mixed $b)
 * @method mixed subtract(mixed $a, mixed $b)
 * @method mixed multiply(mixed $a, mixed $b)
 * @method mixed divide(mixed $a, mixed $b)
 * @method bool equals(mixed $a, mixed $b)
 * @method bool largerThan(mixed $a, mixed $b)
 * @method bool largerOrEquals(mixed $a, mixed $b)
 */
class Computer extends Nette\Object
{

	/** @var ICalculator */
	protected $calculator;

	/** @var IComparator */
	protected $comparator;

	/** @var array */
	private $operations = array(
		'add',
		'subtract',
		'multiply',
		'divide',
	);


	/** @var array */
	private $comparisons = array(
		'equals' => 0,
		'largerThan' => 1,
		'largerOrEquals' => array(1, 0),
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
			return $this->convertToResult(call_user_func_array(array($this->calculator, $name), $this->convertArguments($arguments)));

		} elseif (isset($this->comparisons[$name])) {
			list($a, $b) = $this->convertArguments($arguments);
			$result = $this->comparator->compare($a, $b);
			return is_array($expected = $this->comparisons[$name])
				? in_array($result, $expected, TRUE)
				: $result === $expected;

		} else {
			return parent::__call($name, $arguments);
		}
	}


	protected function convertToResult($value)
	{
		return $this->calculator->convertToScalar($value);
	}


	protected function convertArguments($arguments)
	{
		$converted = array();
		foreach ($arguments as $argument) {
			$converted[] = $this->calculator->convertFromScalar($argument);
		}
		return $converted;
	}

}
