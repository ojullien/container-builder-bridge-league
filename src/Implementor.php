<?php

declare(strict_types=1);

/**
 * @package Oseille\ContainerBuilderBridge\League
 * @link    https://github.com/oseille/container-builder-bridge-league for the canonical source repository
 * @license https://github.com/oseille/container-builder-bridge-league/blob/master/LICENSE MIT
 */

namespace Oseille\ContainerBuilderBridge\League;

use League\Container\Container;
use Oseille\ContainerBuilderBridge\ImplementorInterface;
use Psr\Container\ContainerInterface;

/**
 *
 */
final class Implementor extends ImplementorInterface
{
    /**
     *
     */
    private Container $pContainer;

    /**
     * Undocumented function
     *
     * @param \League\Container\Container $pContainer
     */
    public function __construct(Container $pContainer)
    {
        $this->pContainer = $pContainer;
    }

    /**
     * Builds and returns the PSR-11 container.
     *
     * @return \Psr\Container\ContainerInterface
     */
    public function build(): ContainerInterface
    {
        return $this->pContainer;
    }

    /**
     * Add definitions to the container.
     *
     * @param mixed $definitions,... The definitions.
     * @throws \InvalidArgumentException if $id is not valid
     * @return \Oseille\ContainerBuilderBridge\ImplementorInterface
     */
    public function addDefinitions(...$definitions): ImplementorInterface
    {
        return $this;
    }
}
