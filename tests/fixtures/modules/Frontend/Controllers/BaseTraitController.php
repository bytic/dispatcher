<?php

namespace Modules\Frontend\Controllers;

use Nip\Http\Response\Response;

trait FixtureActions
{
    /**
     * @return Response
     */
    public function index()
    {
        return new Response('index response');
    }

    /**
     * @return string
     */
    public function simpleMethod()
    {
        return 'method';
    }
}

if (class_exists(\Nip\Controllers\Controller::class)) {
    class BaseTraitController extends \Nip\Controllers\Controller
    {
        use FixtureActions;
    }
} else {
    class BaseTraitController
    {
        use FixtureActions;

        public function setRequest($request)
        {
        }
    }
}
