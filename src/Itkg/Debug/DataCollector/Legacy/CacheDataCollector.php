<?php

namespace Itkg\Debug\DataCollector\Legacy;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Itkg\Cache\Event\CacheEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CacheDataCollector extends DataCollector implements EventSubscriberInterface, Renderable
{
    /**
     * Collected data
     *
     * @var array
     */
    protected static $data = array();

    /**
     * Returns the events to which this class has subscribed.
     *
     * Return format:
     *     array(
     *         array('event' => 'the-event-name', 'method' => 'onEventName', 'class' => 'some-class', 'format' => 'json'),
     *         array(...),
     *     )
     *
     * The class may be omitted if the class wants to subscribe to events of all classes.
     * Same goes for the format key.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'cache.load' => 'onCacheLoad',
            'cache.set'  => 'onCacheSet',
            'cache.remove' => 'onCacheRemove'
        );
    }

    /**
     * Called by the DebugBar when data needs to be collected
     *
     * @return array Collected data
     */
    public function collect()
    {
        $collectedData = array();

        $collectedData['general'] = array();
        $loadCount   = 0;
        $setCount    = 0;
        $removeCount = 0;
        $totalSize = 0;
        foreach(self::$data as $key => $values) {
            $collectedData[$key] = $this->getDataFormatter()->formatVar(
                array(
                    'name'   => $key,
                    'load'   => (isset($values['load'])) ? $values['load'] : 0,
                    'set'    =>  (isset($values['set'])) ? $values['set'] : 0,
                    'remove' => (isset($values['remove'])) ? $values['remove'] : 0,
                    'size'   => (isset($values['size'])) ? $values['size'] : '?'
                )
            );
            $loadCount   += (isset($values['load'])) ? $values['load'] : 0;
            $setCount    +=  (isset($values['set'])) ? $values['set'] : 0;
            $removeCount += (isset($values['remove'])) ? $values['remove'] : 0;
            $totalSize += (isset($values['size'])) ? $values['size'] : 0;
        }

        $collectedData['general'] = $this->getDataFormatter()->formatVar(
            array(
                'Cache count'  => sizeof($collectedData) - 1,
                'Cache load'   => $loadCount,
                'Cache remove' => $removeCount,
                'Cache set'    => $setCount,
                'Cache size (bytes) ' => $totalSize
            )
        );

        return $collectedData;
    }

    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    public function getName()
    {
        return 'legacy_cache';
    }

    /**
     * Store loaded information
     *
     * @param CacheEvent $event
     */
    public function onCacheLoad(CacheEvent $event)
    {
        if (isset(self::$data[$event->getKey()]['load'])) {
            self::$data[$event->getKey()]['load'] ++;
        } else {
            self::$data[$event->getKey()]['load'] = 1;
        }

        self::$data[$event->getKey()]['size'] = $event->getSize();
    }

    /**
     * Store cache set information
     *
     * @param $event
     */
    public function onCacheSet(CacheEvent $event)
    {
        if (isset(self::$data[$event->getKey()]['set'])) {
            self::$data[$event->getKey()]['set'] ++;
        } else {
            self::$data[$event->getKey()]['set'] = 1;
        }

        self::$data[$event->getKey()]['size'] = $event->getSize();
    }

    /**
     * Store cache remove information
     *
     * @param $event
     */
    public function onCacheRemove(CacheEvent $event)
    {
        if (isset(self::$data[$event->getKey()]['remove'])) {
            self::$data[$event->getKey()]['remove'] ++;
        } else {
            self::$data[$event->getKey()]['remove'] = 1;
        }
    }

    /**
     * Returns a hash where keys are control names and their values
     * an array of options as defined in {@see DebugBar\JavascriptRenderer::addControl()}
     *
     * @return array
     */
    function getWidgets()
    {
        return array(
            "legacy_cache" => array(
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "legacy_cache",
                "default" => "{}"
            )
        );
    }
}
