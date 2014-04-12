<?php

/**
 * Test: Kdyby\Money\MoneyObjectHydrationListener.
 *
 * @testCase KdybyTests\Money\MoneyObjectHydrationListenerTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Money
 */

namespace KdybyTests\Money;

use Kdyby\Doctrine\Events;
use Doctrine\ORM\Tools\SchemaTool;
use Kdyby;
use Nette;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class MoneyObjectHydrationListenerTest extends \KdybyTests\IntegrationTestCase
{

	public function testFunctional()
	{
		$container = $this->createContainer('order');

		/** @var Kdyby\Doctrine\EntityManager $em */
		$em = $container->getByType('Kdyby\Doctrine\EntityManager');

		$class = $em->getClassMetadata(OrderEntity::getClassName());

		// assert that listener was binded to entity
		Assert::same(array(
			Events::postLoadRelations => array(array('class' => 'Kdyby\\Money\\Mapping\\MoneyObjectHydrationListener', 'method' => Events::postLoadRelations)),
		), $class->entityListeners);

		// generate schema
		$schema = new SchemaTool($em);
		$schema->createSchema($em->getMetadataFactory()->getAllMetadata());

		// test money hydration
		$em->persist(new OrderEntity(1000, 'CZK'));
		$em->flush();
		$em->clear();

		$currencies = $em->getRepository(Kdyby\Money\Currency::getClassName());

		/** @var OrderEntity $order */
		$order = $em->find(OrderEntity::getClassName(), 1);
		Assert::equal(new Kdyby\Money\Money(1000, $currencies->findOneBy(array('code' => 'CZK'))), $order->money);
	}

}

\run(new MoneyObjectHydrationListenerTest());
