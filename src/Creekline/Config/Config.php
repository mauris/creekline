<?php
/**
 * Creekline
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Creekline\Config;

use Packfire\Config\ConfigFactory;

/**
 * Config class
 *
 * Configuration processing class
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\Config
 * @since 1.0.0
 */
class Config
{
    private $projects;

    /**
     * Create a new Config
     * @param \Packfire\Config\IConfig $data The configuration
     * @since 1.0.0
     */
    public function __construct($data)
    {
        $this->sort($data);
    }

    protected function sort($data)
    {
        if ($data && $data->get('projects')) {
            $this->projects = $data->get('projects');
        }
    }

    public function projects()
    {
        return $this->projects;
    }

    public static function load($file)
    {
        $factory = new ConfigFactory();
        return new self($factory->load($file));
    }
}
