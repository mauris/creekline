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

/**
 * IO Interface
 *
 * An interface for input/output
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\IO
 * @since 1.0.0
 */
interface IOInterface {
    
    public function write($message, $newline = true);
    
    public function overwrite($message, $newline = true, $size = null);
    
    public function read();
    
    public function ask($question, $responses);
    
    public function confirm($question);
    
}