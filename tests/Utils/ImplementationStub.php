<?php

declare(strict_types=1);

namespace OJullienTest\Utils;

use League\Container\ServiceProvider\ServiceProviderInterface;
use OJullien\ContainerBuilderBridge\Definition\SequenceInterface;
use OJullien\ContainerBuilderBridge\ImplementationInterface;
use OJullien\ContainerBuilderBridge\League\ExtendedImplementationInterface;
use Psr\Container\ContainerInterface;

/**
 * An implementation of a PSR-11 container builder.
 */
class ImplementationStub implements ExtendedImplementationInterface
{
    /**
     * Builds and returns the PSR-11 container.
     *
     * @return \Psr\Container\ContainerInterface
     */
    public function build(): ContainerInterface
    {
        return new ContainerStub();
    }

    /**
     * Add definitions to the container.
     *
     * @param \OJullien\ContainerBuilderBridge\Definition\SequenceInterface ...$definitions
     * @return \OJullien\ContainerBuilderBridge\ImplementationInterface
     */
    public function setDefinitions(SequenceInterface ...$definitions): ImplementationInterface
    {
        return $this;
    }

    /**
     * Add definitions to the container.
     * We can tell a definition to only resolve once and return the same instance every time it is resolved.
     *
     * @param \OJullien\ContainerBuilderBridge\Definition\SequenceInterface ...$definitions The definitions.
     * @return ExtendedImplementationInterface
     */
    public function setSharedDefinitions(SequenceInterface ...$definitions): ExtendedImplementationInterface
    {
        return $this;
    }

    /**
     * Register a service providers.
     *
     * @link https://container.thephpleague.com/4.x/service-providers/
     * @param \League\Container\ServiceProvider\ServiceProviderInterface $services
     * @return ExtendedImplementationInterface
     */
    public function setServiceProviders(ServiceProviderInterface ...$services): ExtendedImplementationInterface
    {
        return $this;
    }
}
