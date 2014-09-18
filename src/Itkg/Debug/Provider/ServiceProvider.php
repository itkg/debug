<?php

namespace Itkg\Debug\Provider;

use DebugBar\StandardDebugBar;
use Itkg\Core\Provider\ServiceProviderInterface;
use Itkg\Debug\DataCollector\CacheDataCollector;
use Itkg\Debug\DataCollector\ConfigDataCollector;
use Itkg\Debug\DataCollector\DatabaseDataCollector;
use Itkg\Debug\DataCollector\RouteDataCollector;
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
        $container['collector.cache'] = $mainContainer->share(function () {
            return new CacheDataCollector();
        });

        $container['collector.db'] = $mainContainer->share(function () {
            return new DatabaseDataCollector();
        });

        $container['collector.route'] = $mainContainer->share(function () {
            return new RouteDataCollector();
        });

        $container['collector.config'] = $mainContainer->share(function ($c) use ($mainContainer) {

            return new ConfigDataCollector($mainContainer['config']);
        });

        $container['bar'] = $mainContainer->share(function ($c) use ($mainContainer, $container) {
            $bar = new StandardDebugBar();

            // Defaults collectors
            $bar->addCollector($container['collector.config']);
            $bar->addCollector($container['collector.cache']);
            $bar->addCollector($container['collector.db']);
            $bar->addCollector($container['collector.route']);

            return $bar;
        });

        $container['renderer'] = $mainContainer->share(function ($c) use ($container) {
            return $container['bar']->getJavascriptRenderer();
        });
        $mainContainer['debug'] = $container;
    }
}
