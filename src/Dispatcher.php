<?php

namespace Nip\Dispatcher;

use Exception;
use Nip\AutoLoader\AutoLoader;
use Nip\Container\Container;
use Nip\Container\ContainerAwareTrait;
use Nip\Controller;
use Nip\Dispatcher\Exceptions\ForwardException;
use Nip\Dispatcher\Resolver\HasResolverPipelineTrait;
use Nip\Dispatcher\Traits\HasRequestTrait;
use Nip\Http\Response\Response;
use Nip\Request;

/**
 * Class Dispatcher
 * @package Nip\Dispatcher
 */
class Dispatcher
{
    use HasRequestTrait;
    use HasResolverPipelineTrait;
    use ContainerAwareTrait;

    protected $currentController = false;

    protected $hops = 0;

    protected $maxHops = 30;

    /**
     * Create a new controller dispatcher instance.
     *
     * @param  Container  $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }

    /**
     * @param Request|null $request
     * @return null|Response
     * @throws Exception
     */
    public function dispatch(Request $request = null)
    {
        if ($request) {
            $this->setRequest($request);
        } else {
            $request = $this->getRequest();
        }
        $this->hops++;

        if ($this->hops <= $this->maxHops) {
            if ($request->getControllerName() == null) {
                throw new Exception('No valid controller name in request [' . $request->getMCA() . ']');
            }

            $controller = $this->generateController($request);

            if ($controller instanceof Controller) {
                try {
                    $this->currentController = $controller;
                    $controller->setRequest($request);

                    return $controller->dispatch();
                } catch (ForwardException $e) {
                    $return = $this->dispatch();

                    return $return;
                }
            } else {
                throw new Exception('Error finding a valid controller for [' . $request->getMCA() . ']');
            }
        } else {
            throw new Exception("Maximum number of hops ($this->maxHops) has been reached for {$request->getMCA()}");
        }
    }

    /**
     * @param $controller
     * @return mixed
     */
    public static function reverseControllerName($controller)
    {
        return inflector()->unclassify($controller);
    }

    /**
     * @param Request $request
     * @return Controller|null
     * @throws Exception
     */
    public function generateController($request)
    {

        $namespaceClass = $this->generateFullControllerNameNamespace($module, $controller);
        if ($this->isValidControllerNamespace($namespaceClass)) {
            return $this->newController($namespaceClass);
        } else {
            $classicClass = $this->generateFullControllerNameString($module, $controller);
            if ($this->getAutoloader()->isClass($classicClass)) {
                return $this->newController($classicClass);
            }
        }
        throw new Exception(
            'Error finding a valid controller [' . $namespaceClass . '][' . $classicClass . '] for [' . $request->getMCA() . ']'
        );
    }

    /**
     * @param $module
     * @param $controller
     * @return string
     */
    protected function generateFullControllerNameNamespace($module, $controller)
    {
        $name = app('app')->getRootNamespace() . 'Modules\\';
        $module = $module == 'Default' ? 'Frontend' : $module;
        $name .= $module . '\Controllers\\';
        $name .= str_replace('_', '\\', $controller) . "Controller";

        return $name;
    }

    /**
     * @param string $class
     * @return Controller
     */
    public function newController($class)
    {
        $controller = new $class();
        /** @var Controller $controller */
        $controller->setDispatcher($this);

        return $controller;
    }

    /**
     * @return AutoLoader
     */
    protected function getAutoloader()
    {
        return app('autoloader');
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

    /**
     * @return bool
     */
    public function getCurrentController()
    {
        return $this->currentController;
    }
}
