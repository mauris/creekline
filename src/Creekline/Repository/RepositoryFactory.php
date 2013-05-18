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
 * RepositoryFactory class
 *
 * The factory for creating concrete repository implementation by type and string
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\Repository
 * @since 1.0.0
 */
class RepositoryFactory {
    
    public static function byType($type, $identifier){
        switch($type){
            case 'git':
                return new Git($identifier);
                break;
            default:
                throw new \RuntimeException('Unknown Repository Type "' . $type . '"');
                break;
        }
    }
    
}
