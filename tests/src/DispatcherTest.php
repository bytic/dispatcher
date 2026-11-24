<?php
declare(strict_types=1);

namespace Nip\Dispatcher\Tests;

use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Commands\CommandFactory;
use Nip\Dispatcher\Dispatcher;
use Nip\Dispatcher\Exceptions\InvalidCommandException;
use Nip\Controllers\Controller;
use Nip\Http\Request;
use Nip\Http\Request\PsrRequest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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


    public function testEmptyCommand()
    {
        $command = new Command();

        self::expectException(InvalidCommandException::class);
        $this->object->dispatchCommand($command);
    }

    public function testClosure()
    {
        $command = new Command();
        $command->setAutoInitRequest(true);
        $command->getRequest(true)->query->set('variable', 'value');
        $command->setAction(
            function ($request, ResponseInterface $response) {
                $response->setContent($request->query->get('variable'));
                return $response;
            }
        );

        $response = $this->object->dispatchCommand($command)->getReturn();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('value', $response->getContent());
    }

    public function testRequestModuleController()
    {
        $command = new Command();
        $command->setAutoInitRequest(true);
        $command->getRequest(true)
            ->setModuleName('frontend')
            ->setControllerName('baseTrait');

        $response = $this->object->dispatchCommand($command)->getReturn();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('index response', $response->getContent());
    }

    public function testCallPlainControllerWithRequest()
    {
        $controller = new class {
            public function greet($name)
            {
                return 'Hello ' . $name;
            }
        };

        $result = $this->object->call(
            ['instance' => $controller, 'action' => 'greet'],
            ['_request' => new Request(), 'name' => 'Symfony']
        );

        self::assertSame('Hello Symfony', $result);
    }

    public function testDispatchPlainControllerWithRequest()
    {
        $controller = new class {
            public function index()
            {
                return 'plain controller';
            }
        };
        $command = CommandFactory::createFromRequest(new Request());
        $command->setAction(['instance' => $controller, 'action' => 'index']);

        self::assertSame('plain controller', $this->object->dispatchCommand($command)->getReturn());
    }

    public function testDispatchStillPassesRequestToLegacyControllers()
    {
        $controller = new class {
            public $request;

            public function setRequest($request)
            {
                $this->request = $request;
            }

            public function callAction($action)
            {
                return $action;
            }
        };
        $request = new Request();
        $command = CommandFactory::createFromRequest($request);
        $command->setAction(['instance' => $controller, 'action' => 'index']);

        self::assertSame('index', $this->object->dispatchCommand($command)->getReturn());
        self::assertSame($request, $controller->request);
    }

    public function testByticControllerReceivesSharedPsrBridgeForNewHttpRequests()
    {
        $request = new Request();
        if (!class_exists(Controller::class) || !class_exists(PsrRequest::class) || $request instanceof RequestInterface) {
            self::markTestSkipped('Requires ByTIC controllers and the newer ByTIC HTTP request bridge.');
        }

        $controller = new class extends Controller {
            public function __construct()
            {
            }

            public function callAction($method = false, $parameters = [])
            {
                return $method;
            }

            public function show()
            {
                return 'method';
            }
        };
        $command = CommandFactory::createFromRequest($request);
        $command->setAction(['instance' => $controller, 'action' => 'show']);

        self::assertSame('show', $this->object->dispatchCommand($command)->getReturn());
        self::assertInstanceOf(PsrRequest::class, $controller->getRequest());
        self::assertSame($request, $controller->getRequest()->getSymfonyRequest());
        self::assertSame('method', $this->object->call(
            ['instance' => $controller, 'action' => 'show'],
            ['_request' => $request]
        ));
        self::assertSame($request, $controller->getRequest()->getSymfonyRequest());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->object = new Dispatcher();
    }
}
