#!/usr/bin/sh php
<?php

require __DIR__ . '/../vendor/autoload.php';
Nette\Diagnostics\Debugger::enable(FALSE);

/**
 * This script generates Kdyby\Money\CurrencyTable from data provided by ISO 4217 Maintenance Agency
 * Note: Countries without universal currency, funds, testing values and metals are not added to table.
 */

$contents = file_get_contents('http://www.currency-iso.org/dam/downloads/table_a1.xml');
$xml = simplexml_load_string($contents);

$currencies = array();
foreach ($xml->CcyTbl->children() as $entry) {
	if (isset($entry['isFund'])) { // skip funds
		continue;
	}

    if (substr((string)$entry->CtryNm, 0, 2) == 'ZZ') { // skip testing and metals
        continue;
    }

    if ((string)$entry->CcyNm === 'No universal currency') { // skip countries without universal currency
        continue;
    }

	if (!isset($currencies[$code = (string) $entry->Ccy])) {
		$currencies[$code] = array(
			'code' => $code,
			'number' => (string)  $entry->CcyNbr,
			'name' => (string) $entry->CcyNm,
			'decimals' => (int) $entry->CcyMnrUnts,
			'countries' => [ (string) $entry->CtryNm ],
		);

	} else {
		$currencies[$code]['countries'][] = (string) $entry->CtryNm;
	}
}

$generator = new Nette\PhpGenerator\ClassType('CurrencyTable');
$generator->addDocument("This class is generated from data provided by ISO 4217 Maintenance Agency");
$generator->addDocument("Note: Funds, testing values and metals are not present.");
$generator->addConst('VERSION', (string) $xml['Pblshd']);
$records = $generator->addProperty('records', $currencies);
$records->setStatic(TRUE);
$records->setVisibility('private');
$generator->addExtend('Nette\Object');
$generator->setFinal(TRUE);

$constructor = $generator->addMethod('__construct');
$constructor->setVisibility('private');
$constructor->setBody('// cannot be instantiated');

$getRecord = $generator->addMethod('getRecord');
$getRecord->addParameter('code');
$getRecord->addDocument('@param string $code 3 letter ISO 4217 code');
$getRecord->addDocument('@return array|NULL');
$getRecord->setStatic(TRUE);
$getRecord->setBody('return isset(self::$records[$code]) ? self::$records[$code] : NULL;');

$registerRecord = $generator->addMethod('registerRecord');
$registerRecord->addParameter('code');
$registerRecord->addParameter('details')->setTypeHint('array');
$registerRecord->setStatic(TRUE);

$defaults = array('number' => NULL, 'name' => NULL, 'decimals' => 0, 'countries' => array());
$registerRecord->setBody('self::$records[$code = strtoupper($code)] = array(? => $code) + $details + ?;', array('code', $defaults));

$contents = <<<HEREDOC
<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Money;

use Nette;



$generator
HEREDOC;

file_put_contents(__DIR__ . '/../src/Kdyby/Money/CurrencyTable.php', $contents);

