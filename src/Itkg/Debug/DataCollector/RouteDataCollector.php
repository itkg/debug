<?php

namespace Itkg\Debug\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Itkg\Debug\Event\RouteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RouteDataCollector extends DataCollector implements EventSubscriberInterface, Renderable
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
            RouteEvent::ROUTE_MATCH => 'onRouteMatch',
        );
    }

    /**
     * Called by the DebugBar when data needs to be collected
     *
     * @return array Collected data
     */
    public function collect()
    {
        return self::$data;
    }

    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    public function getName()
    {
        return 'route';
    }

    /**
     * Store loaded information
     *
     * @param RouteEvent $event
     */
    public function onRouteMatch(RouteEvent $event)
    {
        self::$data[] = $this->getDataFormatter()->formatVar(
            array(
                'Route match' => $event->getParams()
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
            "route" => array(
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "route",
                "default" => "{}"
            )
        );
    }
}
