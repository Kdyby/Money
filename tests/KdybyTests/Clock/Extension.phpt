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
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ExtensionTest extends Tester\TestCase
{

	/**
	 * @param string $configFile
	 * @return \SystemContainer|Nette\DI\Container
	 */
	public function createContainer($configFile = NULL)
	{
		$config = new Nette\Configurator();
		$config->setTempDirectory(TEMP_DIR);
		$config->addParameters(array('container' => array('class' => 'SystemContainer_' . md5($configFile ?: time()))));
		$config->addConfig(__DIR__ . '/../nette-reset.neon');
		if ($configFile) {
			$config->addConfig(__DIR__ . '/config/' . $configFile . '.neon', $config::NONE);
		}
		Kdyby\Money\DI\MoneyExtension::register($config);

		return $config->createContainer();
	}



	public function testRegisterTypes()
	{
		$container = $this->createContainer('doctrine.types');
		$container->getByType('Kdyby\Doctrine\Connection'); // initializes the types

		Assert::true(Type::getType('amount') instanceof Kdyby\Money\Types\Amount);
		Assert::true(Type::getType('currency') instanceof Kdyby\Money\Types\Currency);
	}

}

\run(new ExtensionTest());
