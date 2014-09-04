<?php

namespace Itkg\Debug\Event;


use Symfony\Component\EventDispatcher\Event;

class DatabaseEvent extends Event
{
    private $query;
    private $data = array();

    public function __construct($query, $data)
    {
        $this->query = $query;
        $this->data  = $data;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getData()
    {
        return $this->data;
    }
}
