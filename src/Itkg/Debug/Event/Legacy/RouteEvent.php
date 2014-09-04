<?php

namespace Itkg\Debug\Event\Legacy;

use Symfony\Component\EventDispatcher\Event;

class RouteEvent extends Event
{
    const ROUTE_MATCH = 'route.match';

    /**
     * @var \Pelican_Route
     */
    private $route;

    /**
     * @var array
     */
    private $params;

    /**
     * Constructor
     *
     * @param \Pelican_Route $route
     */
    public function __construct(\Pelican_Request_Route_Abstract $route, array $params = array())
    {
        $this->route = $route;
        $this->params = $params;
    }

    /**
     * Get route
     * @return \Pelican_Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
} 