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

        $x = 'something';
        $log->debugf('Variable $x=%s', $x);

        $log->turn('off debug'); // for this logger only
        $log->debug('this will not be written');
    }
}
