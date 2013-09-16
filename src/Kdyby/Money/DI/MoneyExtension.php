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
use Nette;
use Nette\PhpGenerator as Code;



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

