<?php

namespace Itkg\Debug\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Itkg\Core\ConfigInterface;

/**
 * Class ConfigDataCollector
 *
 * @package Itkg\Debug\DataCollector
 */
class ConfigDataCollector extends DataCollector implements Renderable
{

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * Constructor
     *
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Called by the DebugBar when data needs to be collected
     *
     * @return array Collected data
     */
    public function collect()
    {
        $config =  (array) $this->config->all();
        ksort($config);

        $data = array();
        foreach ($config as $key => $value) {
            $data[$key] = $this->getDataFormatter()->formatVar($value);
        }

        return $data;
    }

    /**
     * Returns the unique name of the collector
     *
     * @return string
     */
    public function getName()
    {
        return 'config';
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
            "config" => array(
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "config",
                "default" => "{}"
            )
        );
    }
}
