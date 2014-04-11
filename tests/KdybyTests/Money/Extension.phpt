<?php

/**
 * Test: Kdyby\Money\Extension.
 *
 * @testCase Kdyby\Money\ExtensionTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Money
 */

namespace KdybyTests\Money;

use Doctrine\DBAL\Types\Type;
use Kdyby;
use Nette;
use Tester\Assert;
use Tester;



require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ExtensionTest extends \KdybyTests\IntegrationTestCase
{

	public function testRegisterTypes()
	{
		$container = $this->createContainer();
		$container->getByType('Kdyby\Doctrine\Connection'); // initializes the types

		Assert::true(Type::getType('amount') instanceof Kdyby\Money\Types\Amount);
		Assert::true(Type::getType('currency') instanceof Kdyby\Money\Types\Currency);
	}

}

\run(new ExtensionTest());
