<?php

namespace Itkg\Debug\Provider;

use Itkg\Core\Provider\ServiceProviderInterface;

use Itkg\Core\ServiceContainer;
use Itkg\Debug\DataCollector\Legacy\CacheDataCollector;
use Itkg\Debug\DataCollector\ConfigDataCollector;
use Itkg\Debug\DataCollector\Legacy\DatabaseDataCollector;
use Itkg\Debug\DataCollector\Legacy\RouteDataCollector;
use Pimple;

/**
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class ServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param \Pimple $container An Container instance
     */
    public function register(\Pimple $container)
    {
        $debug = new \Pimple();
        $debug['collector.legacy.cache'] = $container->share(function() {
                return new CacheDataCollector();
            });

        $debug['collector.legacy.db'] = $container->share(function() {
                return new DatabaseDataCollector();
            });

        $debug['collector.legacy.route'] = $container->share(function() {
                return new RouteDataCollector();
            });

        $debug['collector.config'] = $container->share(function($c) use ($container) {

                return new ConfigDataCollector($container['config']);
            });

        $debug['bar'] = $container->share(function($c) use ($container, $debug) {
                $debugbar = new \DebugBar\StandardDebugBar();
                $debugbar->addCollector($debug['collector.config']);
                $debugbar->addCollector($debug['collector.legacy.cache']);
                $debugbar->addCollector($debug['collector.legacy.db']);
                $debugbar->addCollector($debug['collector.legacy.route']);
                return $debugbar;
            });

        $debug['renderer'] = $container->share(function($c) use ($debug) {
            return $debug['bar']->getJavascriptRenderer();
        });
        $container['debug'] = $debug;
    }
}