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

    /**
     * @throws \Exception
     */
    public function testActionGetParamWithActionStringSet()
    {
        $command = new Command();
        $command->setAction('Module@Controller::action');
        self::assertEquals('Module@Controller::action', $command->getAction());

        self::expectException(\Exception::class);
        $command->getActionParam('name');
    }

    /**
     * @throws \Exception
     */
    public function testActionGetParamWithActionEmpty()
    {
        $command = new Command();

        self::assertNull($command->getActionParam('name'));
    }

    /**
     * @throws \Exception
     */
    public function testActionSetParamWithActionStringSet()
    {
        $command = new Command();
        $command->setAction('Module@Controller::action');

        self::expectException(\Exception::class);
        $command->setActionParam('name', 'value');
    }

    /**
     * @throws \Exception
     */
    public function testActionSetParamWithActionEmpty()
    {
        $command = new Command();

        self::assertNull($command->getActionParam('name'));

        $command->setActionParam('name', 'value');
        self::assertEquals('value', $command->getActionParam('name'));
        self::assertEquals(['name' => 'value'], $command->getAction());
    }
}
