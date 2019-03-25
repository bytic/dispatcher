<?php

namespace Modules\Frontend\Controllers;

use Nip\Controllers\Controller;
use Nip\Controllers\Traits\BaseControllerTrait;
use Nip\Http\Response\Response;

/**
 * Class BaseTraitController
 * @package Modules\Frontend\Controllers
 */
class BaseTraitController extends Controller
{
    use BaseControllerTrait;

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
