<?php
/**
 * Creekline
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Creekline;

use Creekline\IO\Console;
use Packfire\Options\OptionSet;
use Packfire\FuelBlade\Container;
use Creekline\Config\Config;

/**
 * Application class
 *
 * The main application
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline
 * @since 1.0.0
 */
class Application {
    
    protected $container;
    
    protected $args;
    
    public function __construct($args){
        $container = new Container();
        $this->container = $container;
        
        $io = new Console;
        $this->container['io'] = $io;
        
        $io->write("Creekline composer dependencies checker\n");
        
        $options = new OptionSet();
        $container['options'] = $options;
        
        $this->args = $args;
    }
    
    public function run(){
        $container = $this->container;
        $act = 'help';
        
        $container['options']->addIndex(1, function($value)use(&$act, $container){
            $act = 'skip';
        }, '[Optional] Sets the repository to check');
        
        $container['options']->add('c|config=', function($value)use(&$act, $container){
            $act = 'manager';
            $container['config'] = Config::load($value);
        }, 'Set the configuration');
        
        $container['options']->add('h|help', function()use(&$act){
            $act = 'help';
        }, 'Shows this help message');
        
        $container['options']->parse($this->args);
        
        switch($act){
            case 'skip':
                break;
            case 'manager':
                break;
            case 'help':
            default:
                $container['io']->write($container['options']->help());
                break;
        }
    }
    
}