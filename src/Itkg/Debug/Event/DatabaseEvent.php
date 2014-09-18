<?php

namespace Itkg\Debug\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class DatabaseEvent
 * @package Itkg\Debug\Event
 */
class DatabaseEvent extends Event
{
    /**
     * SQL query
     *
     * @var string
     */
    private $query;

    /**
     * Optionals data
     * @var array
     */
    private $data = array();

    /**
     * @param string $query
     * @param array $data
     */
    public function __construct($query, array $data = array())
    {
        $this->query = $query;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
