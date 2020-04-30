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
final class Implementor implements ImplementorInterface
{
    /**
     * PSR-11 Container.
     *
     * @var \League\Container\Container
     */
    private $pContainer;

    /**
     * Constructor.
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
     * Populates the container with service providers.
     *
     * @link https://container.thephpleague.com/3.x/service-providers/
     * @param array $aProviders Array of class name. The class name should be class that may be
     *                          directly instantiated without any constructor arguments
     * @return void
     */
    private function addProviders(array $aProviders): void
    {
        foreach ($aProviders as $sProvider) {
            $this->pContainer->addServiceProvider($sProvider);
        }
    }

    /**
     * Populates the container with shared objects.
     *
     * @link https://container.thephpleague.com/3.x/definitions/
     * @param array $aSharedFactories An array of service name/factory class name pairs.
     *                                The factories should be any PHP callbacks.
     * @return void
     */
    private function addSharedFactories(array $aSharedFactories): void
    {
        foreach ($aSharedFactories as $sAlias => $aSharedFactory) {
            $this->pContainer->share($sAlias, $aSharedFactory)->addArgument($this->pContainer);
        }
    }

    /**
     * Populates the container with factories.
     *
     * @param array $aFactories An array of service name/factory class name pairs.
     *                          The factories should be any PHP callbacks.
     * @return void
     */
    private function addFactories(array $aFactories): void
    {
        foreach ($aFactories as $sAlias => $aFactory) {
            $this->pContainer->add($sAlias, $aFactory)->addArgument($this->pContainer);
        }
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
     * @return \Oseille\ContainerBuilderBridge\ImplementorInterface
     */
    public function addDefinitions(...$definitions): ImplementorInterface
    {
        // Parse the arguments
        foreach ($definitions as $definition) {
            // Must be an array
            if (! is_array($definition)) {
                throw new \InvalidArgumentException(sprintf(
                    '%s parameter must be an array, %s given',
                    '\Oseille\ContainerBuilderBridge\League\Implementor::addDefinitions()',
                    is_object($definition) ? get_class($definition) : gettype($definition)
                ));
            }

            // Process service rpoviders
            $this->addProviders(array_intersect_key($definition, ['service_providers' => true]));

            // Process shared factories
            $this->addSharedFactories(array_intersect_key($definition, ['shared_factories' => true]));

            // Process factories
            $this->addFactories(array_intersect_key($definition, ['factories' => true]));
            $this->addFactories(array_diff_key($definition, ['factories' => true, 'service_providers' => true, 'shared_factories' => true]));
        }

        return $this;
    }
}
