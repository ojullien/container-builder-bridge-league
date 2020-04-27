<?php

declare(strict_types=1);

namespace OseilleTest\ContainerBuilderBridge;

use OseilleTest\Utils\StubBridge;
use OseilleTest\Utils\StubBuilder;

use function PHPUnit\Framework\assertInstanceOf;

//use PbraidersTest\Utils\EmptyDIFactory;

class AbstractContainerBuilderBridgeTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Oseille\ContainerBuilderBridge\AbstractContainerBuilderBridge
     * @group specification
     */
    public function testCreateContainer()
    {
        $pBuilder = new StubBuilder();
        $pBridge = new StubBridge($pBuilder);
        $pBridge->setContainerBuilder($pBuilder);
        $pContainer = $pBridge->build();
        $this->assertInstanceOf('\Psr\Container\ContainerInterface', $pContainer);
    }
}
