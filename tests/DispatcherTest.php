<?php

namespace Nip\Dispatcher\Tests;

use Nip\Dispatcher\Dispatcher;

/**
 * Class DispatcherTest
 * @package Nip\Dispatcher\Tests
 */
class DispatcherTest extends AbstractTest
{

    /**
     * @var Dispatcher
     */
    protected $object;

    public function testReverseControllerName()
    {
        self::assertSame('event-manager', Dispatcher::reverseControllerName('event_manager'));
        self::assertSame('event_manager', Dispatcher::reverseControllerName('event-manager'));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->object = new Dispatcher();
    }
}
