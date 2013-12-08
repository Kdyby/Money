<?php

namespace Kdyby\Money;

use Kdyby;
use Nette;


/**
 * @method add($a, $b)
 * @method subtract($a, $b)
 * @method multiply($a, $b)
 * @method divide($a, $b)
 */
class Computer extends Nette\Object
{

	/** @var ICalculator */
	private $calculator;

	/** @var IComparer */
	private $comparer;

	/** @var array */
	private static $cache = array();

	/** @var array */
	private $operations = array(
		'add',
		'subtract',
		'multiply',
		'divide',
	);


	public function __construct(ICalculator $calculator, IComparer $comparer = NULL)
	{
		if ($comparer === NULL && !$calculator instanceof IComparer) {
			throw new InvalidArgumentException('Please provide valid comparer.');
		}
		$this->calculator = $calculator;
		$this->comparer = $comparer === NULL ? $calculator : $comparer;
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
