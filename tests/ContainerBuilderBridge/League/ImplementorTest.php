<?php

declare(strict_types=1);

namespace OseilleTest\ContainerBuilderBridge\League;

use League\Container\Container;
use Oseille\ContainerBuilderBridge\League\Implementor;
use Pbraiders\Stdlib\ReflectionTrait;

class ImplementorTest extends \PHPUnit\Framework\TestCase
{
    use ReflectionTrait;

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testBuild()
    {
        $pBuilder = new Implementor(new Container());
        $this->assertInstanceOf('\Psr\Container\ContainerInterface', $pBuilder->build());
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testAddSharedFactories()
    {
        $aDefinitions = [
            'factory_01' => static function (\Psr\Container\ContainerInterface $container): string {
                return 'I_am_factory_01';
            },
        ];
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $pMethod = $this->getMethod('\Oseille\ContainerBuilderBridge\League\Implementor', 'addSharedFactories');
        $pMethod->invokeArgs($pBuilder, [$aDefinitions]);
        $this->assertTrue($pContainer->has('factory_01'), 'container has factory_01');
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testAddFactories()
    {
        $aDefinitions = [
            'factory_02' => static function (\Psr\Container\ContainerInterface $container): string {
                return 'I_am_factory_02';
            },
        ];
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $pMethod = $this->getMethod('\Oseille\ContainerBuilderBridge\League\Implementor', 'addFactories');
        $pMethod->invokeArgs($pBuilder, [$aDefinitions]);
        $this->assertTrue($pContainer->has('factory_02'), 'container has factory_02');
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testAddProviders()
    {
        $aDefinitions = [
            'OseilleTest\Utils\ServiceProvider',
        ];
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $pMethod = $this->getMethod('\Oseille\ContainerBuilderBridge\League\Implementor', 'addProviders');
        $pMethod->invokeArgs($pBuilder, [$aDefinitions]);
        $this->assertTrue($pContainer->has('service1'), 'container has service1');
        $this->assertTrue($pContainer->has('service2'), 'container has service2');
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testGetArrayIntersectKey()
    {
        $aDefinitions = [
            'factories' => [
                'factory_02' => static function (\Psr\Container\ContainerInterface $container): string {
                    return 'I_am_factory_02';
                },
            ],
        ];
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $pMethod = $this->getMethod('\Oseille\ContainerBuilderBridge\League\Implementor', 'getArrayIntersectKey');
        $aResult = $pMethod->invokeArgs($pBuilder, ['factories', $aDefinitions]);
        $this->assertTrue(count($aResult) == 1);
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testGetArrayIntersectKeyDoesNotExist()
    {
        $aDefinitions = [
            'doesnotexist' => [
                'factory_02' => static function (\Psr\Container\ContainerInterface $container): string {
                    return 'I_am_factory_02';
                },
            ],
        ];
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $pMethod = $this->getMethod('\Oseille\ContainerBuilderBridge\League\Implementor', 'getArrayIntersectKey');
        $aResult = $pMethod->invokeArgs($pBuilder, ['factories', $aDefinitions]);
        $this->assertTrue(count($aResult) == 0);
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testGetArrayIntersectError()
    {
        $aDefinitions = [
            'factory_02' => static function (\Psr\Container\ContainerInterface $container): string {
                return 'I_am_factory_02';
            },
        ];
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $pMethod = $this->getMethod('\Oseille\ContainerBuilderBridge\League\Implementor', 'getArrayIntersectKey');
        $aResult = $pMethod->invokeArgs($pBuilder, ['factory_02', $aDefinitions]);
        $this->assertTrue(count($aResult) == 0);
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testAddDefinitions()
    {
        $aDefinitions = [
            'factory_06' => static function (\Psr\Container\ContainerInterface $container): string {
                return 'I_am_factory_06';
            },
        ];
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $pBuilder->addDefinitions($aDefinitions);
        $this->assertTrue($pContainer->has('factory_06'), 'container has factory_06');
    }

    /**
     * @covers \Oseille\ContainerBuilderBridge\League\Implementor
     * @group specification
     */
    public function testAddDefinitionsException()
    {
        $pContainer = new Container();
        $pBuilder = new Implementor($pContainer);
        $this->expectException(\InvalidArgumentException::class);
        $pBuilder->addDefinitions('boom');
    }
}
