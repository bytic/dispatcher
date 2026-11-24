# Dispatcher
ByTIC Dispatcher component

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bytic/dispatcher.svg?style=flat-square)](https://packagist.org/packages/bytic/dispatcher)
[![Latest Stable Version](https://poser.pugx.org/bytic/dispatcher/v/stable)](https://packagist.org/packages/bytic/dispatcher)
[![Latest Unstable Version](https://poser.pugx.org/bytic/dispatcher/v/unstable)](https://packagist.org/packages/bytic/dispatcher)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/bytic/dispatcher/master.svg?style=flat-square)](https://travis-ci.org/bytic/framework)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd/mini.png)](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd)
[![Quality Score](https://img.shields.io/scrutinizer/g/bytic/dispatcher.svg?style=flat-square)](https://scrutinizer-ci.com/g/bytic/dispatcher)
[![StyleCI](https://styleci.io/repos/119902214/shield?branch=master)](https://styleci.io/repos/119902214)
[![Total Downloads](https://img.shields.io/packagist/dt/bytic/dispatcher.svg?style=flat-square)](https://packagist.org/packages/bytic/dispatcher)

## Compatibility

The existing ByTIC dispatcher API remains available. The dispatcher accepts both
ByTIC HTTP requests and PSR server requests; ByTIC HTTP 2.x uses Symfony-backed
requests rather than implementing the PSR request interface directly. For
request-based controller resolution, the request must expose ByTIC's
module, controller and action accessors; a generic PSR request alone is not
sufficient.

Preconstructed controllers do not need to extend a ByTIC controller or implement
`setRequest()`. For example:

```php
$result = $dispatcher->call(
    ['instance' => $controller, 'action' => 'show'],
    ['id' => 42]
);
```

This is an incremental integration point, not Symfony's controller resolver:
the caller is responsible for constructing the controller and supplying its
arguments. Controllers with `setRequest()` continue to receive the request and
must accept the request type being passed. For legacy ByTIC controllers, a
Symfony-backed ByTIC request is supplied through ByTIC's PSR request bridge.

Symfony 8 requires PHP 8.4 or newer and compatible versions of the installed
ByTIC packages, including `bytic/http` 2.x. Current `bytic/controllers` releases
restrict Symfony packages to version 7 or earlier; applications using that
optional package must wait for a compatible release before upgrading to Symfony 8.
Install `bytic/controllers` separately to run the controller integration tests
against the real ByTIC controller.
