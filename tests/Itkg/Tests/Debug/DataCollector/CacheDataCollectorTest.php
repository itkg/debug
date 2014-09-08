<?php

namespace Itkg\Tests\Debug\DataCollector;

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
    }
} 