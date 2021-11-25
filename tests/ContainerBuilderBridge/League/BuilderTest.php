<?php

declare(strict_types=1);

namespace OJullienTest\ContainerBuilderBridge\League;

use OJullien\ContainerBuilderBridge\Definition\Sequence;
use OJullien\ContainerBuilderBridge\League\Builder;
use OJullienTest\Utils\ImplementationStub;
use OJullienTest\Utils\SomeServiceProvider;
use Psr\Container\ContainerInterface;

class BuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \OJullien\ContainerBuilderBridge\League\Builder
     * uses \OJullien\ContainerBuilderBridge\Definition\Sequence
     * @group specification
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @return void
     */
    public function testAddSharedDefinitions(): void
    {
        // Set a builder implementation
        $pImplementation = new ImplementationStub();

        // Set a bridge
        $pBuilder = new Builder($pImplementation);
        $pBuilder->setContainerBuilder($pImplementation); // test parent's setter

        // Get container
        $pSequence = Sequence::getSequence()->withDefinition(\OJullienTest\Utils\SomeServiceProvider::class);
        $pContainer = $pBuilder->addSharedDefinitions($pSequence);
        self::assertInstanceOf(ContainerInterface::class, $pContainer);
    }

    /**
     * @covers \OJullien\ContainerBuilderBridge\League\Builder
     * uses \OJullien\ContainerBuilderBridge\Definition\Sequence
     * @group specification
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @return void
     */
    public function testAddServiceProviders(): void
    {
        // Set a builder implementation
        $pImplementation = new ImplementationStub();

        // Set a bridge
        $pBuilder = new Builder($pImplementation);
        //$pBuilder->setContainerBuilder($pImplementation); // test parent's setter

        // Get container
        $pContainer = $pBuilder->addServiceProviders(new SomeServiceProvider());
        self::assertInstanceOf(ContainerInterface::class, $pContainer);
    }
}
