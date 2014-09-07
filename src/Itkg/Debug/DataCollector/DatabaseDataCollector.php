<?php

namespace Itkg\Debug\DataCollector;


use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Itkg\Debug\Event\DatabaseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DatabaseDataCollector
 * @package Itkg\Debug\DataCollector
 */
class DatabaseDataCollector extends DataCollector implements EventSubscriberInterface, Renderable
{
    protected static $data = array();

    /**
     * Called by the DebugBar when data needs to be collected
     *
     * @return array Collected data
     */
    function collect()
    {
        return self::$data;
    }

    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    function getName()
    {
        return 'database';
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            'db.post_execute' => 'onPostQueryExecute'
        );
    }

    public function onPostQueryExecute(DatabaseEvent $event)
    {
        self::$data[] = $this->getDataFormatter()->formatVar(
            array(
                'query' => $event->getQuery(),
                'data'  => $event->getData()
            )
        );
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
            "database" => array(
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "database",
                "default" => "{}"
            )
        );
    }
}
