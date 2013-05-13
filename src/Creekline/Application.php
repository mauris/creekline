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
use Creekline\Repository\UrlRepository;

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
    
    protected $act = 'help';
    
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
        try{            
            $container = $this->container;
            $manager = new PackageManager($container['io']);
            $container['manager'] = $manager;

            $container['options']->addIndex(1, array($this, 'checkRepository'), '[Optional] Sets the repository to check');

            $container['options']->add('c|config=', array($this, 'loadConfig'), 'Set the configuration');

            $container['options']->add('h|help', function(){}, 'Shows this help message');

            $container['options']->parse($this->args);

            switch($this->act){
                case 'skip':
                    break;
                case 'manager':
                    $manager = new PackageManager($this->container['io']);
                    $manager->run(new Repository\Git('https://github.com/packfire/concrete.git'));
                    break;
                case 'help':
                default:
                    $container['io']->write($container['options']->help());
                    break;
            }
        }catch(Exception $ex){
            
        }
    }
    
    public function loadConfig($file){
        $this->act = 'manager';
        $this->container['config'] = Config::load($file);
    }
    
    public function checkRepository($identifier){
        $this->act = 'skip';
        $repository = UrlRepository::factory($identifier);
        if($repository){
            $this->container['manager']->run($repository);
        }else{
            throw new \RuntimeException("Unknown repository given");
        }
    }
    
}