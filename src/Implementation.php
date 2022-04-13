<?php

/**
 * @package OJullien\ContainerBuilderBridge\League
 * @link    https://github.com/ojullien/container-builder-bridge-league for the canonical source repository
 * @license https://github.com/ojullien/container-builder-bridge-league/blob/master/LICENSE MIT
 */

declare(strict_types=1);

namespace OJullien\ContainerBuilderBridge\League;

use League\Container\Container;
use League\Container\ServiceProvider\ServiceProviderInterface;
use OJullien\ContainerBuilderBridge\Definition\SequenceInterface;
use OJullien\ContainerBuilderBridge\ImplementationInterface;
use Psr\Container\ContainerInterface;

/**
 * Implementor to use with the builder bridge
 */
final class Implementation implements ExtendedImplementationInterface
{
    /**
     * Constructor.
     *
     * @param \League\Container\Container $container
     */
    public function __construct(private Container $container)
    {
    }

    /**
     * Builds and returns the PSR-11 container.
     *
     * @return \Psr\Container\ContainerInterface
     */
    public function build(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Add definitions to the container.
     *
     * @param \OJullien\ContainerBuilderBridge\Definition\SequenceInterface ...$definitions The definitions.
     * @return \OJullien\ContainerBuilderBridge\ImplementationInterface
     */
    public function setDefinitions(SequenceInterface ...$definitions): ImplementationInterface
    {
        foreach ($definitions as $sequence) {
            foreach ($sequence as $key => $value) {
                $pDefinition = $this->container->add($key, $value);
                if (\is_callable($value)) {
                    $pDefinition->addArgument($this->container);
                }
            }
        }
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
        foreach ($definitions as $sequence) {
            foreach ($sequence as $key => $value) {
                $pDefinition = $this->container->addShared($key, $value);
                if (\is_callable($value)) {
                    $pDefinition->addArgument($this->container);
                }
            }
        }
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
        foreach ($services as $service) {
            $this->container->addServiceProvider($service);
        }
        return $this;
    }
}
