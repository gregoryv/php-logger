<?php
require_once 'vendor/autoload.php';

use gregoryv\logger\Logger;

class SomeClassWithLogging
{

    function __construct()
    {
        $this->log = new Logger($this);
    }

    public function doSomething()
    {
        $log = new Logger($this);
        $log->info('doing something here');
    }
}
