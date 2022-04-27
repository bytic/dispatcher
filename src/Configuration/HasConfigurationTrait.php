<?php
declare(strict_types=1);

namespace Nip\Dispatcher\Configuration;

/**
 * Trait HasConfigurationTrait
 */
trait HasConfigurationTrait
{
    /**
     * @var null|Configuration
     */
    protected $configuration = null;

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        if ($this->configuration === null) {
            $this->initConfiguration();
        }
        return $this->configuration;
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration): void
    {
        $this->configuration = $configuration;
    }


    public function initConfiguration()
    {
        $this->configuration = (new Configuration());
    }
}
