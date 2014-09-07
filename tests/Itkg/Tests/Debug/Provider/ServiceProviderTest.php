<?php

namespace Itkg\Tests\Debug\Provider;


use Itkg\Core\Config;
use Itkg\Core\ServiceContainer;
use Itkg\Debug\Provider\ServiceProvider;

/**
 * Class ServiceProviderTest
 */
class ServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $container = new ServiceContainer();

        $container->setConfig(new Config());
        $container->register(new ServiceProvider());
        
        // collectors
        $this->assertInstanceOf('Itkg\Debug\DataCollector\CacheDataCollector', $container['debug']['collector.cache']);
        $this->assertInstanceOf('Itkg\Debug\DataCollector\ConfigDataCollector', $container['debug']['collector.config']);
        $this->assertInstanceOf('Itkg\Debug\DataCollector\RouteDataCollector', $container['debug']['collector.route']);
        $this->assertInstanceOf('Itkg\Debug\DataCollector\DatabaseDataCollector', $container['debug']['collector.db']);

        // bar
        $this->assertInstanceOf('DebugBar\StandardDebugBar', $container['debug']['bar']);

        // renderer
        $this->assertInstanceOf('DebugBar\JavascriptRenderer', $container['debug']['renderer']);
    }
}
