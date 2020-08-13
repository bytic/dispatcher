<?php

use Nip\Container\Container;

require dirname(__DIR__) . '/vendor/autoload.php';

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

$container = new \Nip\Container\Container();
$container->share('inflector', new \Nip\Inflector\Inflector());

Container::setInstance($container);

\Nip\Dispatcher\Resolver\Cache\FileManager::empty();
