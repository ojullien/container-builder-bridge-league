<?php

/**
 * @package OJullien\ContainerBuilderBridge\League
 * @link    https://github.com/ojullien/container-builder-bridge-league for the canonical source repository
 * @license https://github.com/ojullien/container-builder-bridge-league/blob/master/LICENSE MIT
 */

declare(strict_types=1);

namespace OJullien\ContainerBuilderBridge\League;

use League\Container\ServiceProvider\ServiceProviderInterface;
use OJullien\ContainerBuilderBridge\Builder as ContainerBuilderBridgeBuilder;
use OJullien\ContainerBuilderBridge\Definition\SequenceInterface;
use Psr\Container\ContainerInterface;

/**
 * Extended bridge abstraction
 */
final class Builder extends ContainerBuilderBridgeBuilder
{

    /**
     * Initializes with one of the implementation objects.
     *
     * @param ExtendedImplementationInterface $builder
     */
    public function __construct(private ExtendedImplementationInterface $builder)
    {
        parent::__construct($builder);
    }

    /**
     * Builds the PSR-11 container with shared difinitions and returns it.
     *
     * @param \OJullien\ContainerBuilderBridge\Definition\SequenceInterface ...$definitions Shared
     * @return \Psr\Container\ContainerInterface
     */
    public function addSharedDefinitions(SequenceInterface ...$definitions): ContainerInterface
    {
        return $this->builder->setSharedDefinitions(...$definitions)->build();
    }

    /**
     * Builds the PSR-11 container with service providers and returns it.
     *
     * @link https://container.thephpleague.com/4.x/service-providers/
     * @param \League\Container\ServiceProvider\ServiceProviderInterface $services
     * @return \Psr\Container\ContainerInterface
     */
    public function addServiceProviders(ServiceProviderInterface ...$services): ContainerInterface
    {
        return $this->builder->setServiceProviders(...$services)->build();
    }
}
