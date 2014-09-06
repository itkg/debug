<?php

/**
 * Class RouteEventTest
 */
class RouteEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testConstructor()
    {
        $route = '/debugger';
        $params = array(
            'controller' => 'MyController',
            'action'     => 'index'
        );

        $event = new \Itkg\Debug\Event\RouteEvent($route, $params);

        $this->assertEquals($route, $event->getRoute());
        $this->assertEquals($params, $event->getParams());
    }
}
