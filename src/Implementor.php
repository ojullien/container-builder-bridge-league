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
     * @return Container
     */
    public function build(): ContainerInterface
    {
        return $this->pContainer;
    }

    /**
     * Populates the container with service providers.
     *
     * @link https://container.thephpleague.com/3.x/service-providers/
     * @param array<array-key, mixed> $aProviders Array of class name.
     *                                            The class name should be class that may be
     *                                            directly instantiated without any constructor arguments
     * @return void
     */
    private function addProviders(array $aProviders): void
    {
        /**
         * @var string $sProvider Full class name
         */
        foreach ($aProviders as $sProvider) {
            $this->pContainer->addServiceProvider((string) $sProvider);
        }
    }

    /**
     * Populates the container with shared objects.
     *
     * @link https://container.thephpleague.com/3.x/definitions/
     * @param array<array-key, mixed> $aSharedFactories An array of service name/factory class name pairs.
     *                                                  The factories should be any PHP callbacks.
     * @return void
     */
    private function addSharedFactories(array $aSharedFactories): void
    {
        /**
         * @var callable $pCallable Any PHP callable
         * @var string $sAlias Alias
         */
        foreach ($aSharedFactories as $sAlias => $pCallable) {
            $this->pContainer->share((string) $sAlias, $pCallable)->addArgument($this->pContainer);
        }
    }

    /**
     * Populates the container with factories.
     *
     * @param array<array-key, mixed> $aFactories An array of service name/factory class name pairs.
     *                                            The factories should be any PHP callbacks.
     * @return void
     */
    private function addFactories(array $aFactories): void
    {
        /**
         * @var callable $pCallable Any PHP callable
         * @var string $sAlias Alias
         */
        foreach ($aFactories as $sAlias => $pCallable) {
            $this->pContainer->add((string) $sAlias, $pCallable)->addArgument($this->pContainer);
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
     * @param array<int,array> $definitions,... The definitions.
     *
     * @throws \InvalidArgumentException if $definitions is not an array
     *
     * @return self
     */
    public function addDefinitions(...$definitions): self
    {
        /**
         * Parse the arguments
         *
         * @var array<array-key, mixed> $definition
         */
        foreach ($definitions as $definition) {
            // Must be an array
            if (! is_array($definition)) {
                throw new \InvalidArgumentException(sprintf(
                    '%s parameter must be an array, %s given',
                    '\Oseille\ContainerBuilderBridge\League\Implementor::addDefinitions()',
                    is_object($definition) ? get_class($definition) : gettype($definition)
                ));
            }

            // Process service providers
            $this->addProviders($this->getArrayIntersectKey('service_providers', $definition));

            // Process shared factories
            $this->addSharedFactories($this->getArrayIntersectKey('shared_factories', $definition));

            // Process factories
            $this->addFactories($this->getArrayIntersectKey('factories', $definition));
            $this->addFactories(array_diff_key($definition, ['factories' => true, 'service_providers' => true, 'shared_factories' => true]));
        }

        return $this;
    }

    /**
     * Returns the value of the intersection of arrays using keys for comparison.
     * ALso, returns an empty array if the value is not an array.
     *
     * @param string                  $sKey         The key to check
     * @param array<array-key, mixed> $aDefinitions The array with the key to check
     * @return array<array-key, mixed>
     */
    private function getArrayIntersectKey(string $sKey, array $aDefinitions): array
    {
        $aReturn = [];
        $aBuffer = array_intersect_key($aDefinitions, [$sKey => true]);
        if ((count($aBuffer) > 0) && \is_array($aBuffer[$sKey])) {
            $aReturn = $aBuffer[$sKey];
        }
        return $aReturn;
    }
}
