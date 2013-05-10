<?php
namespace Creekline;

class MockFailProcess {
    
    private $cmd;
    
    public function __construct($cmd){
        $this->cmd = $cmd;
    }
    
    public function run(){
        return 1;
    }
    
    public function getOutput(){
        return "";
    }
    
}