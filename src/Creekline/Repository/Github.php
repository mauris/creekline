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

/**
 * Github class
 *
 * A Github repository
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\Repository
 * @since 1.0.0
 */
class Github extends Git
{
    
    public function __construct($url)
    {
        if (preg_match('{^[a-z0-9\-]+\/[a-z0-9\-]+$}is', $url)) {
            $url = 'git@github.com:' . $url . '.git';
        } elseif (preg_match('{^https{0,1}://(www\.){0,1}github\.com/[a-z0-9\-\.]+/[a-z0-9\-\.]+(?<!\.git)$}is', $url)) {
            $url .= '.git';
        }
        parent::__construct($url);
    }
}
