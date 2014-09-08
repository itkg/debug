<?php

namespace Itkg\Tests\Debug\Event;

/**
 * Class DatabaseEventTest
 */
class DatabaseEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     */
    public function testConstructor()
    {
        $query = 'SELECT * FROM MY_TABLE';
        $data = array(
            'time' => '10'
        );

        $event = new \Itkg\Debug\Event\DatabaseEvent($query, $data);

        $this->assertEquals($query, $event->getQuery());
        $this->assertEquals($data, $event->getData());
    }
}
