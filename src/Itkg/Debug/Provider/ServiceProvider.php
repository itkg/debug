<?php

namespace Itkg\Debug\Provider;

use DebugBar\StandardDebugBar;
use Itkg\Core\Provider\ServiceProviderInterface;

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
     * @param \Pimple $mainContainer An Container instance
     */
    public function register(\Pimple $mainContainer)
    {
        $container = new \Pimple();
        $container['collector.legacy.cache'] = $mainContainer->share(function() {
                return new CacheDataCollector();
            });

        $container['collector.legacy.db'] = $mainContainer->share(function() {
                return new DatabaseDataCollector();
            });

        $container['collector.legacy.route'] = $mainContainer->share(function() {
                return new RouteDataCollector();
            });

        $container['collector.config'] = $mainContainer->share(function($c) use ($mainContainer) {

                return new ConfigDataCollector($mainContainer['config']);
            });

        $container['bar'] = $mainContainer->share(function($c) use ($mainContainer, $container) {
                $containerbar = new StandardDebugBar();
                $containerbar->addCollector($container['collector.config']);
                $containerbar->addCollector($container['collector.legacy.cache']);
                $containerbar->addCollector($container['collector.legacy.db']);
                $containerbar->addCollector($container['collector.legacy.route']);
                return $containerbar;
            });

        $container['renderer'] = $mainContainer->share(function($c) use ($container) {
            return $container['bar']->getJavascriptRenderer();
        });
        $mainContainer['debug'] = $container;
    }
}