<?php

use Tracy\Debugger;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$allowed_ips = [
	'89.102.224.123',
];
$configurator->setDebugMode($allowed_ips);
if (php_sapi_name() == 'cli') {
	$configurator->setDebugMode(true);
}
//$configurator->setDebugMode(true);
Debugger::$email = 'eflyax42@gmail.com';

$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();


$configurator->addConfig(__DIR__ . '/config/config.neon');
if (!isset($_SERVER['REMOTE_ADDR']) OR in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) { // !isset is for doctrine
	$configurator->addConfig(__DIR__ . '/config/config.local.neon');
} else {
	$configurator->addConfig(__DIR__ . '/config/config.production.neon');
}

require_once(__DIR__ . '/libs/bootstrapIncludes.php');

$container = $configurator->createContainer();

return $container;
