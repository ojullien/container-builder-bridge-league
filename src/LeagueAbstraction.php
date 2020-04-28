<?php

declare(strict_types=1);

/**
 * @package Oseille\ContainerBuilderBridge\League
 * @link    https://github.com/oseille/container-builder-bridge-league for the canonical source repository
 * @license https://github.com/oseille/container-builder-bridge-league/blob/master/LICENSE MIT
 */

namespace Oseille\ContainerBuilderBridge\League;

use Oseille\ContainerBuilderBridge\Abstraction;
use Psr\Container\ContainerInterface;

/**
 *
 */
final class LeagueAbstraction extends Abstraction
{
    /**
     * Builds and returns the PSR-11 container.
     *
     * @return \Psr\Container\ContainerInterface
     */
    public function build(): ContainerInterface
    {
        return $this->pContainerBuilder->build();
    }

    /**
     * Add definitions to the container.
     *
     * @param mixed $definitions,... Array of definitions
     * @return \Oseille\ContainerBuilderBridge\Abstraction
     */
    public function addDefinitions(...$definitions): Abstraction
    {
        $this->pContainerBuilder->addDefinitions($definitions);
        return $this;
    }
}
