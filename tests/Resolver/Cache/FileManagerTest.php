<?php

namespace Nip\Dispatcher\Tests\Resolver\Cache;

use Nip\Dispatcher\Resolver\Cache\DefinitionsCollection;
use Nip\Dispatcher\Resolver\Cache\FileManager;
use Nip\Dispatcher\Tests\AbstractTest;

/**
 * Class FileManagerTest
 * @package Nip\Dispatcher\Tests\Resolver\Cache
 */
class FileManagerTest extends AbstractTest
{
    public function testWrite()
    {
        $filePath = FileManager::filePath();

        $collection = new DefinitionsCollection([
            'test1' => 'Test1',
            'test2' => 'Test2'
        ]);

        FileManager::write($collection);

        self::assertFileExists($filePath);
    }

    public function testRead()
    {
        $filePath = TEST_FIXTURE_PATH . '/cache/dispatcher.php';

        $collection = new DefinitionsCollection([]);

        FileManager::read($collection, $filePath);

        static::assertCount(2, $collection->all());
        self::assertSame('Test1', $collection->get('test1'));
    }
}
