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

use Creekline\IO\IOInterface;
use Creekline\Repository\RepositoryInterface;

/**
 * PackageManager class
 *
 * The manager for downloading and running tests for a package
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline
 * @since 1.0.0
 */
class PackageManager {
    
    /**
     *
     * @var \Creekline\IO\IOInterface
     */
    private $io;
    
    public function __construct(IOInterface $io){
        $this->io = $io;
    }
    
    public function run(RepositoryInterface $repository){
        $this->io->write('Preparing for ' . $repository->identifier(), false);
        
        $cwd = getcwd();
        $folder = sys_get_temp_dir() . '/' . FolderUtility::randomFolderName();
        mkdir($folder);
        chdir($folder);
        
        $this->io->overwrite('Downloading ' . $repository->identifier(), false);
        $repository->fetch();
        
        $this->io->overwrite('Downloading Composer ... ', false);
        $composer = new Composer();
        $result = $composer->detect();
        if(!$result){
            $composer->download();
        }
        $this->io->overwrite('Installing project dependencies ... ', false);
        $components = $composer->install();
        
        $this->io->overwrite('Checking ' . $repository->identifier() . ' ... ', false);        
        $upgrades = $composer->update();
        
        chdir($cwd);
        FolderUtility::clearFolder($folder);
        
        $this->io->write("Done");
        foreach($components as $name => $version){
            $this->io->write('    ' . $name . ' ' . $version, false);
            if(isset($upgrades[$name])){
                $this->io->write(' => ' . $upgrades[$name], false);
            }
            $this->io->write('');
        }
        
    }
    
}