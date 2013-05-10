
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

/**
 * Composer class
 *
 * The composer interaction class
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline
 * @since 1.0.0
 */
class Composer {
    
    public function download(){
        $cmd = 'php -r "eval(\'?>\'.file_get_contents(\'https://getcomposer.org/installer\'));"';
        $proc = $this->processor;
        $process = new $proc($cmd);
        if ($process->run() !== 0) {
            throw new \RuntimeException('Failed to download Composer. Output: ' . $process->getOutput());
        }
        if(!is_file('composer.phar')){
            throw new \RuntimeException('Failed to download Composer: "composer.phar" still not found. Output: ' . $process->getOutput());
        }
    }
    
    public function install(){
        $cmd = 'php composer.phar install';
        $proc = $this->processor;
        $process = new $proc($cmd);
        if ($process->run() !== 0) {
            throw new \RuntimeException('Failed to install dependencies via Composer. Output: ' . $process->getOutput());
        }
    }
    
    public function update(){
        $cmd = 'php composer.phar update';
        $proc = $this->processor;
        $process = new $proc($cmd);
        $output = $process->getOutput();
        if ($process->run() !== 0) {
            throw new \RuntimeException('Failed to update dependencies via Composer. Output: ' . $output);
        }
    }
    
}
