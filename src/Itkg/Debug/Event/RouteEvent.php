<?php

namespace Itkg\Debug\Event;

use Symfony\Component\EventDispatcher\Event;

class RouteEvent extends Event
{
    const ROUTE_MATCH = 'route.match';

    /**
     * @var $mixed
     */
    private $route;

    /**
     * @var array
     */
    private $params;

    /**
     * Constructor
     *
     * @param mixed $route
     * @param array $params
     */
    public function __construct($route, array $params = array())
    {
        $this->route = $route;
        $this->params = $params;
    }

    /**
     * Get route
     * @return $mixed
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
