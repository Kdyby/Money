<?php

namespace Kdyby\Money;

use Kdyby;
use Nette;


class Computer extends Nette\Object
{

	/** @var ICalculator */
	private $calculator;

	/** @var array */
	private static $cache = [];


	public function __construct(ICalculator $calculator)
	{
		$this->calculator = $calculator;
	}


	public function compute($expression, array $parameters, $precision = 0)
	{
		static $map = [
			'+' => 'add',
			'-' => 'subtract',
			'*' => 'multiply',
			'/' => 'divide',
			'%' => 'modulo',
			'^' => 'power',
		];
		$map;
	}


	public function compare($a, $b)
	{
		try {
			# if is correction necessary ie is return value is not a subset of parameter value
			self::assertValidParameters($this->calculator, 'compare', $parameters = [ $a, $b ]);
			return $this->calculator->compare($a, $b);
		} catch (InvalidArgumentException $e) {
			# if is possible to correct parameters
			$corrected = self::tryCorrectParameters($this->calculator, 'compare', $parameters);
			return call_user_func_array([ $this->calculator, 'compare' ], $corrected);
		}
	}


	private static function assertValidParameters($object, $method, $parameters)
	{
		list($types) = self::getTypeOfParametersAndReturnValue($object, $method);
		foreach ($types as $index => $acceptedTypes) {
			if (!in_array($type = gettype($parameters[$index]), $acceptedTypes)) {
				$acceptedType = array_pop($acceptedTypes);
				throw new InvalidArgumentException("Parameter $index: Expected " . ($acceptedTypes ? implode(', ', $acceptedTypes) . ' or ' : '')  . "$acceptedType type $type given.");
			}
		}
	}


	private static function tryCorrectParameters(ICalculator $calculator, $method, $parameters)
	{
		$corrected = [];
		list($types) = self::getTypeOfParametersAndReturnValue($calculator, $method);
		foreach ($types as $index => $acceptedTypes) {
			if (!in_array($type = gettype($parameters[$index]), $acceptedTypes)) {
				$acceptedType = end($acceptedTypes);
				$corrected[] = $calculator->convertToType($parameters[$index], $acceptedType);

			} else {
				$corrected[] = $parameters[$index];
			}
		}

		return $corrected;
	}


	private static function getTypeOfParametersAndReturnValue($object, $method)
	{
		if (!isset(self::$cache[$key = (is_object($object) ? get_class($object) : $object) . "\x00" . $method])) {
			$reflection = Nette\Reflection\Method::from($object, $method);
			$parsed = [];
			foreach ($reflection->getAnnotations() as $key => $annotation) {
				if ($key === 'param') {
					foreach ($annotation as $value) {
						$parsed[0][] = self::sanitizeTypes(self::parseTypesFromAnnotationValue($value));
					}

				} elseif ($key === 'return') {
					$parsed[1] = self::sanitizeTypes(self::parseTypesFromAnnotationValue($annotation[0]));
				}
			}
			return self::$cache[$key] = $parsed + [ 0 => [], 1 => [] ];
		}
		return self::$cache[$key];
	}


	private static function parseTypesFromAnnotationValue($value)
	{
		list($types) = explode(' ', $value);
		return explode('|', $types);
	}


	private static function sanitizeTypes($types)
	{
		$converted = [];
		foreach ($types as $type) {
			switch ($type) {
				case 'bool':
				case 'double':
				case 'int':
				case 'resource':
				case 'string':
					$converted[] = $type;
					break;

				case 'float':
					$converted[] = 'double';
					break;

				default:
					throw new InvalidArgumentException("Type $type is not supported.");
					break;
			}
		}
		return $converted;
	}

}
