<?php

declare(strict_types=1);

namespace OJullienTest\ContainerBuilderBridge\League;

use League\Container\Container;
use OJullien\ContainerBuilderBridge\Definition\Sequence;
use OJullien\ContainerBuilderBridge\League\Implementation;
use OJullienTest\Utils\SomeServiceProvider;
use Psr\Container\ContainerInterface;

class ImplementationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \OJullien\ContainerBuilderBridge\League\Implementation
     * @uses \OJullien\ContainerBuilderBridge\Definition\Sequence
     * @group specification
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * throws \InvalidArgumentException
     */
    public function testSetDefinitions(): void
    {
        // Definition as Values
        $aDefinitionsAsValues = [
            'bob@example.com',
            'alice@example.com',
        ];
        $pSequenceAsValues = Sequence::getSequence()
            ->withDefinition('database.host', 'localhost')
            ->withDefinition('database.port', 5000)
            ->withDefinition('report.recipients', $aDefinitionsAsValues);
        self::assertCount(3, $pSequenceAsValues, 'Sequence as values count.');

        // Definition as Factories
        $pSequenceAsFactories = Sequence::getSequence()
            ->withDefinition(
                'factory',
                static function (ContainerInterface $container): string {
                    return 'connect ' . (string) $container->get('database.host') . ':' . (string) $container->get('database.port');
                }
            );

        // Definition as Object
        $pSequenceAsObject = Sequence::getSequence()->withDefinition(\OJullienTest\Utils\SomeServiceProvider::class);

        // Build Container
        $pImplementation = new Implementation(new Container());
        $pContainer = $pImplementation->setDefinitions(
            $pSequenceAsValues,
            $pSequenceAsFactories,
            $pSequenceAsObject
        )->build();

        self::assertInstanceOf(\Psr\Container\ContainerInterface::class, $pContainer);

        self::assertTrue($pContainer->has('database.host'), 'container has database.host');
        self::assertTrue($pContainer->has('database.port'), 'container has database.port');
        self::assertTrue($pContainer->has('report.recipients'), 'container has report.recipients');

        self::assertTrue($pContainer->has('factory'), 'container has factory');
        self::assertSame('connect localhost:5000', $pContainer->get('factory'), "Factory test");

        /** @var \OJullienTest\Utils\SomeServiceProvider $pObject1 */
        $pObject1 = $pContainer->get(\OJullienTest\Utils\SomeServiceProvider::class);
        /** @var \OJullienTest\Utils\SomeServiceProvider $pObject2 */
        $pObject2 = $pContainer->get(\OJullienTest\Utils\SomeServiceProvider::class);
        self::assertNotSame($pObject1, $pObject2, 'Object are not the same');
    }

    /**
     * @covers \OJullien\ContainerBuilderBridge\League\Implementation::setServiceProviders
     * @uses \OJullien\ContainerBuilderBridge\League\Implementation::__construct
     * @uses \OJullien\ContainerBuilderBridge\League\Implementation::build
     * @uses \OJullienTest\Utils\SomeServiceProvider
     * @group specification
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     */
    public function testSetServiceProvider(): void
    {
        $pImplementation = new Implementation(new Container());
        $pContainer = $pImplementation->setServiceProviders(new SomeServiceProvider())->build();
        self::assertInstanceOf(\Psr\Container\ContainerInterface::class, $pContainer);
        self::assertTrue($pContainer->has('service1'), 'container has service1');
        self::assertTrue($pContainer->has('service2'), 'container has service2');
    }

    /**
     * @covers \OJullien\ContainerBuilderBridge\League\Implementation::setSharedDefinitions
     * @uses \OJullien\ContainerBuilderBridge\League\Implementation::__construct
     * @uses \OJullien\ContainerBuilderBridge\League\Implementation::build
     * @uses \OJullienTest\Utils\SomeServiceProvider
     * @group specification
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSetSharedDefinitions(): void
    {
        $pSequence = Sequence::getSequence()->withDefinition(\OJullienTest\Utils\SomeServiceProvider::class);
        $pImplementation = new Implementation(new Container());
        $pContainer = $pImplementation->setSharedDefinitions($pSequence)->build();

        /** @var \OJullienTest\Utils\SomeServiceProvider $pObject1 */
        $pObject1 = $pContainer->get(\OJullienTest\Utils\SomeServiceProvider::class);

        /** @var \OJullienTest\Utils\SomeServiceProvider $pObject2 */
        $pObject2 = $pContainer->get(\OJullienTest\Utils\SomeServiceProvider::class);

        self::assertSame($pObject1, $pObject2, 'Object are the same');
    }

    /**
     * @covers \OJullien\ContainerBuilderBridge\League\Implementation::setSharedDefinitions
     * @uses \OJullien\ContainerBuilderBridge\League\Implementation::__construct
     * @uses \OJullien\ContainerBuilderBridge\League\Implementation::build
     * @uses \OJullienTest\Utils\SomeServiceProvider
     * @group specification
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSetSharedCallable(): void
    {
        $pSequence = Sequence::getSequence()
            ->withDefinition(\OJullienTest\Utils\SomeServiceProvider::class)
            ->withDefinition(
                'factory',
                static function (ContainerInterface $container): mixed {
                    return $container->get(\OJullienTest\Utils\SomeServiceProvider::class);
                }
            );
        $pImplementation = new Implementation(new Container());
        $pContainer = $pImplementation->setSharedDefinitions($pSequence)->build();

        /** @var \OJullienTest\Utils\SomeServiceProvider $pObject1 */
        $pObject1 = $pContainer->get('factory');

        /** @var \OJullienTest\Utils\SomeServiceProvider $pObject2 */
        $pObject2 = $pContainer->get('factory');

        self::assertSame($pObject1, $pObject2, 'Object are the same');
    }
}
