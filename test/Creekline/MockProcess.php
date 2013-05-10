<?php
namespace Creekline\Repository;

class MockProcess {
    
    private $cmd;
    
    public function __construct($cmd){
        $this->cmd = $cmd;
    }
    
    public function run(){
        return strpos($this->cmd, 'FAIL') === false ? 0 : 100;
    }
    
    public function getOutput(){
        return "";
    }
    
}