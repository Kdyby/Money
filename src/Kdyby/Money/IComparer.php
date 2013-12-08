<?php

namespace Kdyby\Money;


interface IComparer
{

	/**
	 * Returns -1, 0 or 1 if $a > $b, $a == $b or $a < $b.
	 * @return int
	 */
	function compare($a, $b);

}
