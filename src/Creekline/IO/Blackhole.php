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
 * Blackhole class
 *
 * Implementation of a nullified input/output
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\IO
 * @since 1.0.0
 */
class Blackhole implements IOInterface
{
    
    public function ask($question, $responses)
    {
        return '';
    }

    public function confirm($question)
    {
        return true;
    }

    public function overwrite($message, $newline = true, $size = null)
    {
        
    }

    public function read()
    {
        return '';
    }

    public function write($message, $newline = true)
    {
        
    }
}
