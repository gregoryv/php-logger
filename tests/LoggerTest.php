<?php
use gregoryv\logger\CachedWriter;
use gregoryv\logger\Logger;

class LoggerTest extends PHPUnit_Framework_TestCase {


    public function methodNames()
    {
        return array(
            array('debug'),
            array('info'),
            array('notice'),
            array('warn'),
            array('error'),
            array('critical'),
            array('alert'),
            array('emergency')
        );
    }
    /**
    * @test
    * @group unit
    * @dataProvider methodNames
    */
    function toggle_severity_level_off($name) {
        $writer = new CachedWriter();
        Logger::setWriter($writer);
        $log = new Logger($this);
        $log->turn("off $name");
        call_user_func(array($log, $name), 'something');
        $this->assertCount(0, $writer->cache);
    }

    /**
    * @test
    * @group unit
    */
    function all_level_messages_are_propagated_to_writer() {
        $log = new Logger('me');
        $writer = new CachedWriter();
        Logger::setWriter($writer);
        $i = 0;
        $log->emergency("message");
        $this->assertEquals($writer->cache[$i++], 'me EMERGENCY message');
        $log->alert("message");
        $this->assertEquals($writer->cache[$i++], 'me ALERT message');
        $log->critical("message");
        $this->assertEquals($writer->cache[$i++], 'me CRITICAL message');
        $log->error("message");
        $this->assertEquals($writer->cache[$i++], 'me ERROR message');
        $log->notice("message");
        $this->assertEquals($writer->cache[$i++], 'me NOTICE message');
        $log->warn("message");
        $this->assertEquals($writer->cache[$i++], 'me WARNING message');
        $log->info("message");
        $this->assertEquals($writer->cache[$i++], 'me INFO message');
        $log->debug("message");
        $this->assertEquals($writer->cache[$i++], 'me DEBUG message');
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
