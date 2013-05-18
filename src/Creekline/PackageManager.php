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
     * The IO channel to read/write to
     * @var \Creekline\IO\IOInterface
     * @since 1.0.0
     */
    protected $io;
    
    protected $counter = 0;
    
    /**
     * Create a new PackageManager
     * @param \Creekline\IO\IOInterface $io The IO interface to input/output to
     * @since 1.0.0
     */
    public function __construct(IOInterface $io){
        $this->io = $io;
    }
    
    /**
     * Perform update checking for a repository
     * @param \Creekline\Repository\RepositoryInterface $repository The repository to check
     * @since 1.0.0
     */
    public function run(RepositoryInterface $repository){
        ++$this->counter;
        
        $this->io->write('  [' . $this->counter . '] ', false);
        
        $this->io->write('Preparing for ' . $repository->identifier(), false);
        
        $cwd = getcwd();
        $folder = sys_get_temp_dir() . '/' . FolderUtility::randomFolderName();
        mkdir($folder);
        chdir($folder);
        
        $this->io->overwrite('Downloading ' . $repository->identifier() . ' ... ', false);
        $repository->fetch();
        
        $this->io->overwrite('Downloading Composer ... ', false);
        $composer = new Composer();
        $result = $composer->detect();
        if(!$result){
            $composer->download();
        }
        $this->io->overwrite('Installing project dependencies ... ', false);
        $components = $composer->install();
        
        $this->io->overwrite('Checking ' . $repository->identifier() . ' for updates ... ', false);        
        $upgrades = $composer->update();
        
        chdir($cwd);
        FolderUtility::clearFolder($folder);
        
        $this->io->write("Done");
        if($components){
            foreach($components as $name => $version){
                $this->io->write('      ' . $name . '  (' . $version . ')', false);
                if(isset($upgrades[$name])){
                    $this->io->write(' => [' . $upgrades[$name] . ']', false);
                }
                $this->io->write('');
            }
        }else{
            $this->io->write('    No dependencies found.');
        }
        $this->io->write('');
    }
    
}