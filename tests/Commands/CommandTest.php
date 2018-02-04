<?php

namespace Nip\Dispatcher\Tests\Commands;

use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Tests\AbstractTest;
use Nip\Http\Response\Response;
use Nip\Request;

/**
 * Class CommandTest
 * @package Nip\Dispatcher\Tests\Commands
 */
class CommandTest extends AbstractTest
{
    public function testGetSetRequest()
    {
        $command = new Command();
        self::assertEquals(null, $command->getRequest());
        self::assertFalse($command->hasRequest());

        $request = new Request();
        $command->setRequest($request);

        self::assertTrue($command->hasRequest());
        self::assertEquals($request, $command->getRequest());
    }


    public function testGetSetResponse()
    {
        $command = new Command();
        self::assertEquals(null, $command->getResponse());
        self::assertFalse($command->hasResponse());

        $response = new Response();
        $command->setResponse($response);
        self::assertTrue($command->hasResponse());
        self::assertEquals($response, $command->getResponse());
    }
}
