<?php

namespace Nip\Dispatcher;

use Exception;
use Nip\Container\Container;
use Nip\Container\ContainerAwareTrait;
use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Commands\CommandFactory;
use Nip\Dispatcher\Exceptions\ForwardException;
use Nip\Dispatcher\Resolver\HasResolverPipelineTrait;
use Nip\Dispatcher\Resolver\Pipeline\InstanceBuilder;
use Nip\Dispatcher\Traits\HasCommandsCollection;
use Nip\Dispatcher\Traits\HasRequestTrait;
use Nip\Request;

/**
 * Class Dispatcher
 * @package Nip\Dispatcher
 */
class Dispatcher
{
    use ContainerAwareTrait;
    use HasResolverPipelineTrait;
    use HasRequestTrait;
    use HasCommandsCollection;

    /**
     * Create a new controller dispatcher instance.
     *
     * @param  Container $container
     * @return void
     */
    public function __construct(Container $container = null)
    {
        if ($container instanceof Container) {
            $this->setContainer($container);
        }
    }

    /**
     * @param Request|null $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws Exception
     */
    public function dispatch(Request $request = null)
    {
        if ($request) {
            $this->setRequest($request);
        }

        $command = CommandFactory::createFromRequest($request);
        return $this->dispatchCommand($command)->getReturn();
    }


    /**
     * @param $action
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function call($action, $params = [])
    {
        $action = is_array($action) ? $action : ['controller' => $action];
        $command = CommandFactory::createFromAction($action);
        if (isset($params['_request'])) {
            $command->setRequest($params['_request']);
            unset($params['_request']);
        }
        $command->setActionParam('params', $params);
        return $this->getResolverPipeline(InstanceBuilder::class)
            ->process($command)
            ->getReturn();
    }

    /**
     * @param Request|null $request
     * @return
     */
    public function callFromRequest(Request $request = null)
    {
        $command = CommandFactory::createFromRequest($request);
        return $this->getResolverPipeline(InstanceBuilder::class)
            ->process($command)
            ->getReturn();
    }

    /**
     * @param Command $command
     * @return Command
     */
    public function dispatchCommand(Command $command)
    {
        $this->getCommandsCollection()[] = $command;


        try {
            return $this->processCommand($command);
        } catch (ForwardException $exception) {
            $command = CommandFactory::createFromForwardExecption($exception);
            $return = $this->dispatchCommand($command);

            return $return;
        }
    }

    /**
     * @param bool $params
     */
    public function throwError($params = false)
    {
//        $this->getFrontController()->getTrace()->add($params);
        $this->setErrorController();
        $this->forward('index');

        return;
    }

    /**
     * @return $this
     */
    public function setErrorController()
    {
        $this->getRequest()->setActionName('index');
        $this->getRequest()->setControllerName('error');
        $this->getRequest()->setModuleName('default');

        return $this;
    }

    /**
     * @param bool $action
     * @param bool $controller
     * @param bool $module
     * @param array $params
     * @throws ForwardException
     */
    public function forward($action = false, $controller = false, $module = false, $params = [])
    {
        $this->getRequest()->setActionName($action);

        if ($controller) {
            $this->getRequest()->setControllerName($controller);
        }
        if ($module) {
            $this->getRequest()->setModuleName($module);
        }

        if (is_array($params)) {
            $this->getRequest()->attributes->add($params);
        }

        throw new ForwardException;
    }
}
