<?php

namespace Itkg\Tests\Debug\DataCollector;

use DebugBar\DataFormatter\DataFormatter;
use Itkg\Debug\DataCollector\DatabaseDataCollector;
use Itkg\Core\Event\DatabaseEvent;

/**
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class DatabaseDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCollect()
    {
        $query = 'SELECT * FROM MY_TABLE';
        $data = array(
           'my resultSET'
        );
        $executionTime = 0.12;
        $dbEvent = new DatabaseEvent($query, $executionTime, $data);

        $dbcollector = new DatabaseDataCollector();
        $dbcollector->onPostQueryExecute($dbEvent);
        $dbcollector->onPostQueryExecute($dbEvent);

        $dataFormatter = new DataFormatter();

        $this->assertEquals(
            array(
                0 => $dataFormatter->formatVar(array(
                    'query' => $query,
                    'data'  => $data
                )),
                1 => $dataFormatter->formatVar(array(
                    'query' => $query,
                    'data'  => $data
                ))
            ),
            $dbcollector->collect()
        );
    }

    public function testWidgets()
    {
        $collector = new DatabaseDataCollector();
        $name = $collector->getName();
        $widgets = $collector->getWidgets();

        $this->assertArrayHasKey($name, $widgets);
        $this->assertEquals($name, $widgets[$name]['map']);

    }
} 