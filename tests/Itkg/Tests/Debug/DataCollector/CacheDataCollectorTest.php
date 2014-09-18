<?php

namespace Itkg\Tests\Debug\DataCollector;

use DebugBar\DataFormatter\DataFormatter;
use Itkg\Core\Cache\Event\CacheEvent;
use Itkg\Debug\DataCollector\CacheDataCollector;

/**
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class CacheDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollect()
    {
        $loadCacheEvent = new CacheEvent('my_cache_key', 86400, 'test');
        $removeCacheEvent = new CacheEvent('my_cache_key_remove', 86400);
        $setCacheEvent = new CacheEvent('my_cache_key_set', 86400, 'test');

        $collector = new CacheDataCollector();

        $collector->onCacheLoad($loadCacheEvent);
        // Test double load same cache
        $collector->onCacheLoad($loadCacheEvent);


        $collector->onCacheSet($setCacheEvent);

        // Test double set same cache
        $collector->onCacheSet($setCacheEvent);

        $collector->onCacheRemove($removeCacheEvent);

        // Test double remove same cache
        $collector->onCacheRemove($removeCacheEvent);

        $dataFormatter = new DataFormatter();

        $result = array(
            'general' => $dataFormatter->formatVar(
                array(
                    'Cache count'         => 3,
                    'Cache load'          => 2,
                    'Cache remove'        => 2,
                    'Cache set'           => 2,
                    'Cache size (bytes) ' => 16
                )
            ),
            'my_cache_key' => $dataFormatter->formatVar(
                array(
                    'name'   => 'my_cache_key',
                    'load'   => 2,
                    'set'    => 0,
                    'remove' => 0,
                    'size'   => 4
                )
            ),
            'my_cache_key_remove' => $dataFormatter->formatVar(
                array(
                    'name'   => 'my_cache_key_remove',
                    'load'   => 0,
                    'set'    => 0,
                    'remove' => 2,
                    'size'   => 0
                )
            ),
            'my_cache_key_set'  => $dataFormatter->formatVar(
                array(
                    'name'   => 'my_cache_key_set',
                    'load'   => 0,
                    'set'    => 2,
                    'remove' => 0,
                    'size'   => 4
                )
            )
        );

        $this->assertEquals($result, $collector->collect());
    }

    public function testWidgets()
    {
        $collector = new CacheDataCollector();
        $name = $collector->getName();
        $widgets = $collector->getWidgets();

        $this->assertArrayHasKey($name, $widgets);
        $this->assertEquals($name, $widgets[$name]['map']);

    }
}
