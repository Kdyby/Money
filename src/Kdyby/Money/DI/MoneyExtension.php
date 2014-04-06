<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money\DI;

use Kdyby;
use Nette\PhpGenerator as Code;
use Nette;



if (!class_exists('Nette\DI\CompilerExtension')) {
	class_alias('Nette\Config\CompilerExtension', 'Nette\DI\CompilerExtension');
	class_alias('Nette\Config\Compiler', 'Nette\DI\Compiler');
	class_alias('Nette\Config\Helpers', 'Nette\DI\Config\Helpers');
}

if (isset(Nette\Loaders\NetteLoader::getInstance()->renamed['Nette\Configurator']) || !class_exists('Nette\Configurator')) {
	unset(Nette\Loaders\NetteLoader::getInstance()->renamed['Nette\Configurator']); // fuck you
	class_alias('Nette\Config\Configurator', 'Nette\Configurator');
}

if (!interface_exists('Kdyby\Doctrine\DI\IDatabaseTypeProvider')) {
	eval('namespace Kdyby\Doctrine\DI { interface IDatabaseTypeProvider {} }');
}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class MoneyExtension extends Nette\DI\CompilerExtension implements Kdyby\Doctrine\DI\IDatabaseTypeProvider
{

	/**
	 * @var array
	 */
	public $defaults = array(
		'currencies' => array(),
		'rates' => array(
			'static' => array(),
		),
	);



	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('rates'))
			->setClass('Kdyby\Money\Exchange\StaticExchanger', array($config['rates']['static']));
	}



	public function afterCompile(Code\ClassType $class)
	{
		$config = $this->getConfig($this->defaults);

		if (!empty($config['currencies'])) {
			$init = $class->addMethod('_kdyby_initialize_currencies');
			$init->setVisibility('protected');

			foreach ($config['currencies'] as $code => $details) {
				$details = Nette\DI\Config\Helpers::merge($details, array('number' => NULL, 'name' => NULL, 'decimals' => 0, 'countries' => array()));
				$init->addBody('?(?, ?);', array(new Code\PhpLiteral('Kdyby\Money\CurrencyTable::registerRecord'), strtoupper($code), $details));
			}

			$class->methods['initialize']->addBody('$this->_kdyby_initialize_currencies();');
		}
	}



	/**
	 * Returns array of typeName => typeClass.
	 *
	 * @return array
	 */
	public function getDatabaseTypes()
	{
		return array(
			Kdyby\Money\Types\Amount::AMOUNT => 'Kdyby\Money\Types\Amount',
			Kdyby\Money\Types\Currency::CURRENCY => 'Kdyby\Money\Types\Currency',
		);
	}



	public static function register(Nette\Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Nette\DI\Compiler $compiler) {
			$compiler->addExtension('money', new MoneyExtension());
		};
	}

}

