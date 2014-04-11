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
use Kdyby\Events\DI\EventsExtension;
use Nette\PhpGenerator as Code;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class MoneyExtension extends Nette\DI\CompilerExtension implements Kdyby\Doctrine\DI\IDatabaseTypeProvider
{

	/**
	 * @var array
	 */
	public $defaults = array(
		'cache' => 'default'
	);



	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('moneyHydrationListener'))
			->setClass('Kdyby\Money\Mapping\MoneyObjectHydrationListener', array(
				Kdyby\DoctrineCache\DI\Helpers::processCache($this, $config['cache'], 'money'),
			))
			->addTag(EventsExtension::SUBSCRIBER_TAG);
	}



	/**
	 * Returns array of typeName => typeClass.
	 *
	 * @return array
	 */
	public function getDatabaseTypes()
	{
		return array(
			Kdyby\Money\Types\Money::MONEY => 'Kdyby\Money\Types\Money',
		);
	}



	public static function register(Nette\Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Nette\DI\Compiler $compiler) {
			$compiler->addExtension('money', new MoneyExtension());
		};
	}

}

