<?php

namespace Nip\Dispatcher\Tests\Commands;

use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Commands\CommandsCollection;
use Nip\Dispatcher\Tests\AbstractTest;

/**
 * Class CommandTest
 * @package Nip\Dispatcher\Tests\Commands
 */
class CommandsCollectionTest extends AbstractTest
{
    public function testOverflow()
    {
        $collection = new CommandsCollection();
        $collection->setMaxHops(3);

        self::assertEquals(3, $collection->getMaxHops());
        self::assertEquals(0, $collection->getHops());
        self::assertFalse($collection->overflow());

        $command = new Command();
        $collection[] = $command;
        $collection[] = $command;
        self::assertEquals(2, $collection->getHops());
        self::assertFalse($collection->overflow());

        $collection[] = $command;
        self::assertEquals(3, $collection->getHops());
        self::assertFalse($collection->overflow());

        self::expectException(\Exception::class);
        $collection[] = $command;
        self::assertTrue($collection->overflow());
    }
}
