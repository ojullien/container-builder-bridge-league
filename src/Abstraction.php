<?php

declare(strict_types=1);

/**
 * @package Oseille\ContainerBuilderBridge\League
 * @link    https://github.com/oseille/container-builder-bridge-league for the canonical source repository
 * @license https://github.com/oseille/container-builder-bridge-league/blob/master/LICENSE MIT
 */

namespace Oseille\ContainerBuilderBridge\League;

use Oseille\ContainerBuilderBridge\Abstraction as BridgeAbstraction;
use Psr\Container\ContainerInterface;

/**
 * League\Container builder abstraction.
 */
final class Abstraction extends BridgeAbstraction
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
     * A definition is a key value paired like:
     * [
     *  Acme\Foo::class => function (ContainerInterface $container) {...},
     *  Acme\Bar::class => function (ContainerInterface $container) {...},
     *  ...
     * ]
     *
     * or (\League\Container specific)
     * [
     *  'shared_factories' => [
     *    Acme\Bar::class => function (ContainerInterface $container) {...},
     *    ...
     *   ],
     *  'factories' => [
     *    Acme\Baz::class => function (ContainerInterface $container) {...},
     *    ...
     *   ],
     *  'service_providers' => [
     *     Acme\Foo::class,
     *     ...
     *   ]
     * ]
     *
     * @param mixed $definitions,... The definitions.
     * @throws \InvalidArgumentException if $definitions is not an array
     * @return \Oseille\ContainerBuilderBridge\Abstraction
     */
    public function addDefinitions(...$definitions): BridgeAbstraction
    {
        $this->pContainerBuilder->addDefinitions(...$definitions);
        return $this;
    }
}
