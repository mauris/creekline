<?php
/**
 * Creekline
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Creekline\Repository;

use Packfire\FuelBlade\IConsumer;

/**
 * Git class
 *
 * A git repository
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\Repository
 * @since 1.0.0
 */
class Git extends UrlRepository implements IConsumer {
    
    protected $branch = 'master';
    
    protected $processor = '\\Symfony\\Component\\Process\\Process';
    
    public function __construct($url) {
        $this->url = $url;
    }
    
    public function identifier(){
        return $this->url;
    }

    public function fetch() {
        $cmd = 'git init && git remote add origin "' . $this->url . '" && git pull origin "' . $this->branch . '"';
        $proc = $this->processor;
        $process = new $proc($cmd);
        if ($process->run() !== 0) {
            throw new \RuntimeException('Failed to fetch from "' . $this->url . '". Output: ' . $process->getOutput());
        }
    }
    
    public function __invoke($c) {
        if(isset($c['url'])){
            $this->url = $c['url'];
        }
        if(isset($c['branch'])){
            $this->branch = $c['branch'];
        }
        if(isset($c['processor'])){
            $this->processor = $c['processor'];
        }
    }
    
}