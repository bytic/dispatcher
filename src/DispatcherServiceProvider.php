<?php
declare(strict_types=1);

namespace Nip\Dispatcher;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

/**
 * Class MailServiceProvider.
 */
class DispatcherServiceProvider extends AbstractSignatureServiceProvider
{
    public const SERVICE_DISPATCHER = 'dispatcher';

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            static::SERVICE_DISPATCHER,
            Dispatcher::class
        ];
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
        $this->getContainer()->share('dispatcher', function () {
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
