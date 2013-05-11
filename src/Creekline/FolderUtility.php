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
 * FolderUtlity class
 *
 * Utility for folder operations
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline
 * @since 1.0.0
 */
class FolderUtility {
    
    public static function randomFolderName(){
        do {
              $folder = substr(sha1(mt_rand() . dechex(time() & 0xFF)), 5, 10)
                      . dechex(time() & 0xF) . substr(sha1(mt_rand()), 5, 9);
        } while(is_dir($folder));
        return $folder;
    }
    
    public static function clearFolder($folder){
        if (!is_dir($folder) || is_link($folder)) return @unlink($folder); 
        foreach (scandir($folder) as $file) { 
            if ($file == '.' || $file == '..') continue; 
            if (!self::clearFolder($folder . '/' . $file)) { 
                chmod($folder . '/' . $file, 0777); 
                if (!self::clearFolder($folder . '/' . $file)) return false; 
            }; 
        } 
        return @rmdir($folder); 
    }
    
}