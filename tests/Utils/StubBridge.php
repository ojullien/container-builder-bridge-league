<?php

declare(strict_types=1);

namespace OseilleTest\Utils;

use Psr\Container\ContainerInterface;
use Oseille\ContainerBuilderBridge\AbstractContainerBuilderBridge;

class StubBridge extends AbstractContainerBuilderBridge
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
     * @param array $definitions Array of definitions
     * @return \Oseille\ContainerBuilderBridge\AbstractContainerBuilderBridge
     */
    public function addDefinitions(...$definitions): AbstractContainerBuilderBridge
    {
        return $this;
    }
}
