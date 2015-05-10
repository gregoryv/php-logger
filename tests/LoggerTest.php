<?php
require_once __DIR__ . '/../vendor/autoload.php';

use gregoryv\logger\CachedWriter;
use gregoryv\logger\Logger;

class LoggerTest extends PHPUnit_Framework_TestCase {

    function setUp() {
        $this->writer = new CachedWriter();
        Logger::setWriter($this->writer);
    }

    /**
    * @test
    * @group unit
    */
    function info_level_messages_are_propagated_to_writer() {
        $writer = new CachedWriter();
        Logger::setWriter($writer);
        $log = new Logger('me');
        $log->info("message");
        $this->assertEquals($writer->cache[0], 'me INFO message');
        $log->warn("message");
        $this->assertEquals($writer->cache[1], 'me WARNING message');
        $log->error("message");
        $this->assertEquals($writer->cache[2], 'me ERROR message');
        $log->debug("message");
        $this->assertEquals($writer->cache[3], 'me DEBUG message');
    }

}
