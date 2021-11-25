<?php

/**
 * @package OJullien\ContainerBuilderBridge
 * @link    https://github.com/ojullien/container-builder-bridge for the canonical source repository
 * @license https://github.com/ojullien/container-builder-bridge/blob/master/LICENSE MIT
 */

declare(strict_types=1);

namespace OJullien\ContainerBuilderBridge\League;

use League\Container\ServiceProvider\ServiceProviderInterface;
use OJullien\ContainerBuilderBridge\Definition\SequenceInterface;
use OJullien\ContainerBuilderBridge\ImplementationInterface;
use Psr\Container\ContainerInterface;

/**
 * The extended interface for League builder implementations.
 */
interface ExtendedImplementationInterface extends ImplementationInterface
{
    /**
     * Add definitions to the container.
     * We can tell a definition to only resolve once and return the same instance every time it is resolved.
     *
     * @param \OJullien\ContainerBuilderBridge\Definition\SequenceInterface ...$definitions The definitions.
     * @return ExtendedImplementationInterface
     */
    public function setSharedDefinitions(SequenceInterface ...$definitions): ExtendedImplementationInterface;

    /**
     * Register a service providers.
     *
     * @link https://container.thephpleague.com/4.x/service-providers/
     * @param \League\Container\ServiceProvider\ServiceProviderInterface $services
     * @return ExtendedImplementationInterface
     */
    public function setServiceProviders(ServiceProviderInterface ...$services): ExtendedImplementationInterface;
}
