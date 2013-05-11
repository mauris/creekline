<?php
/**
 * Creekline
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Creekline\IO;

use Clio\Console as Clio;

/**
 * Console class
 *
 * Implementation for console standard input/output
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\IO
 * @since 1.0.0
 */
class Console implements IOInterface {
    
    private $lastMessage;
    
    public function ask($question, $responses) {
        return Clio::select($question, $responses);
    }

    public function confirm($question) {
        return Clio::confirm($question);
    }

    public function overwrite($message, $newline = true, $size = null) {
        $this->write(str_repeat("\x08", $size), false);
        $this->write($message, $newline);
    }

    public function read() {
        return Clio::input();
    }

    public function write($message, $newline = true) {
        $this->lastMessage = $message . ($newline ? "\n": '');
        Clio::output($this->lastMessage);
    }
    
}