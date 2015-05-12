<?php
use gregoryv\logger\CachedWriter;
use gregoryv\logger\Logger;

class LoggerTest extends PHPUnit_Framework_TestCase {

    /**
    * @test
    * @group unit
    */
    function all_level_messages_are_propagated_to_writer() {
        $log = new Logger('me');
        $writer = new CachedWriter();
        Logger::setWriter($writer);
        $log->info("message");
        $this->assertEquals($writer->cache[0], 'me INFO message');
        $log->warn("message");
        $this->assertEquals($writer->cache[1], 'me WARNING message');
        $log->error("message");
        $this->assertEquals($writer->cache[2], 'me ERROR message');
        $log->debug("message");
        $this->assertEquals($writer->cache[3], 'me DEBUG message');
    }

    /**
    * @test
    * @group unit
    */
    function object_context_uses_its_class_name() {
        $log = new Logger($this);
        $writer = new CachedWriter();
        Logger::setWriter($writer);
        $log->info('message');
        $this->assertEquals($writer->cache[0], 'LoggerTest INFO message');
    }

}
