<?php

namespace Itkg\Tests\Debug\DataCollector;

use DebugBar\DataFormatter\DataFormatter;
use Itkg\Core\Config;
use Itkg\Core\ServiceContainer;
use Itkg\Debug\DataCollector\ConfigDataCollector;

/**
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class ConfigDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test collect config, format var, order config
     */
    public function testCollect()
    {
        $config = new Config();
        $config->set('foo', 'bar');
        $config->set('bar', 'foo');

        $configDataCollector = new ConfigDataCollector($config);
        $dataFormatter = new DataFormatter();

        $this->assertEquals(
            array(
                'bar' => $dataFormatter->formatVar('foo'),
                'foo' => $dataFormatter->formatVar('bar')
            ),
            $configDataCollector->collect()
        );
    }
} 