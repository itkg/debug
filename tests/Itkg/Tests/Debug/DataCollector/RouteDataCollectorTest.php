<?php

namespace Itkg\Tests\Debug\DataCollector;

use DebugBar\DataFormatter\DataFormatter;
use Itkg\Debug\DataCollector\RouteDataCollector;
use Itkg\Debug\Event\RouteEvent;

class RouteDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollect()
    {
        $params = array(
            'controller' => 'My\Simple\Controller',
            'action'     => 'index',
            'route'      => '/my_route',
            'params'     => array(
                'id' => 12
            )
        );
        $rEvent = new RouteEvent('/my_route', $params);

        $params2 = array(
            'controller' => 'My\Internal\Controller',
            'action'     => 'show',
            'route'      => '/my_internal_route',
            'params'     => array(
                'id' => 12
            )
        );
        $rEvent2 = new RouteEvent('/my_internal_route', $params2);

        $dbcollector = new RouteDataCollector();
        $dbcollector->onRouteMatch($rEvent);
        $dbcollector->onRouteMatch($rEvent2);
        $dataFormatter = new DataFormatter();

        $this->assertEquals(
            array(
                0 => $dataFormatter->formatVar(array(
                        'Route match' => $params
                )),
                1 => $dataFormatter->formatVar(array(
                        'Route match' => $params2
                ))
            ),
            $dbcollector->collect()
        );
    }

    public function testWidgets()
    {
        $collector = new RouteDataCollector();
        $name = $collector->getName();
        $widgets = $collector->getWidgets();

        $this->assertArrayHasKey($name, $widgets);
        $this->assertEquals($name, $widgets[$name]['map']);

    }
}
