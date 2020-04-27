<?php

declare(strict_types=1);

/**
 * @package Oseille\ContainerBuilderBridge
 * @link    https://github.com/oseille/container-builder-bridge for the canonical source repository
 * @license https://github.com/oseille/container-builder-bridge/blob/master/LICENSE MIT
 */

namespace Oseille\ContainerBuilderBridge;

use Psr\Container\ContainerInterface;

/**
 * Container Builder Bridge abstraction class.
 */
abstract class AbstractContainerBuilderBridge
{

    /**
     * A implementation of a container builder.
     *
     * @var \Oseille\ContainerBuilderBridge\ContainerBuilderInterface
     */
    protected ContainerBuilderInterface $pContainerBuilder;

    /**
     * Initializes with one of the implementation objects.
     *
     * @param ContainerBuilderInterface $builder
     */
    public function __construct(ContainerBuilderInterface $builder)
    {
        $this->pContainerBuilder = $builder;
    }

    /**
     * The Bridge pattern allows replacing the attached implementation object
     * dynamically.
     *
     * @param ContainerBuilderInterface $builder
     * @return void
     */
    public function setContainerBuilder(ContainerBuilderInterface $builder): void
    {
        $this->pContainerBuilder = $builder;
    }

    /**
     * Builds and returns the PSR-11 container.
     *
     * @return \Psr\Container\ContainerInterface
     */
    abstract public function build(): ContainerInterface;

    /**
     * Add definitions to the container.
     *
     * @param mixed $definitions,... Array of definitions
     * @return \Oseille\ContainerBuilderBridge\AbstractContainerBuilderBridge
     */
    abstract public function addDefinitions(...$definitions): AbstractContainerBuilderBridge;
}
