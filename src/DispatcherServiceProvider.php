<?php

namespace Nip\Dispatcher;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

/**
 * Class MailServiceProvider.
 */
class DispatcherServiceProvider extends AbstractSignatureServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['dispatcher', Dispatcher::class];
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerDispatcher();
    }

    protected function registerDispatcher()
    {
        $this->getContainer()->alias('dispatcher', Dispatcher::class);
        $this->getContainer()->share('dispatcher', function() {
            return self::newDispatcher();
        });
    }

    /**
     * @return Dispatcher
     */
    public static function newDispatcher()
    {
        return new Dispatcher();
    }
}
