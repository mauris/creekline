<?php
namespace Creekline\MockProcess;

class Success
{
    
    private $cmd;
    
    public function __construct($cmd)
    {
        $this->cmd = $cmd;
    }
    
    public function run()
    {
        return 0;
    }
    
    public function getOutput()
    {
        return "";
    }
}
