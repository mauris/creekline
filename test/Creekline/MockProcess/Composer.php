<?php
namespace Creekline\MockProcess;

class Composer
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
        return <<<EOF
Loading composer repositories with package information
Updating dependencies (including require-dev)
  - Removing symfony/process (v2.1.6)
  - Installing symfony/process (v2.2.1)
    Loading from cache

  - Removing symfony/finder (v2.1.6)
  - Installing symfony/finder (v2.2.1)
    Downloading: 100%

Writing lock file
Generating autoload files
EOF;
    }
}
