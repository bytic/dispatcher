<?php

namespace Nip\Dispatcher\Tests\Resolver\Cache;

use Nip\Dispatcher\Resolver\Cache\DefinitionsCollection;
use Nip\Dispatcher\Resolver\Cache\FileManager;
use Nip\Dispatcher\Tests\AbstractTest;

/**
 * Class FileManagerTest
 * @package Nip\Dispatcher\Tests\Resolver\Cache
 */
class DefinitionCollectionTest extends AbstractTest
{
    public function testReplace()
    {
        $collection = new DefinitionsCollection([
            'test1' => 'Test1',
            'test2' => 'Test2'
        ]);

        $collection->replace(['test1' => 'Test11', 'test3' => 'Test3']);

        static::assertCount(3, $collection->all());
        self::assertSame('Test11', $collection->get('test1'));
    }
}
