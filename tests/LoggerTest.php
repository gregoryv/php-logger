<?php
use gregoryv\logger\Logger;
use gregoryv\logger\SeverityWriterInterface;
require_once 'DataProvider.php';

class LoggerTest extends PHPUnit_Framework_TestCase implements SeverityWriterInterface {
    use DataProvider;

    private $result;

    public function swrite($severity, $message='')
    {
        $this->result = $message;
    }

    public function setUp()
    {
        Logger::setWriter($this);
        $this->log = new Logger($this);
    }

    /**
    * @test
    * @group unit
    * @dataProvider methodNames
    */
    function toggle_severity_level_off($name) {
        $this->log->turn("off $name");
        $before = $this->result;
        call_user_func(array($this->log, $name), $before . '..');
        $this->assertEquals($before, $this->result);
    }

    /**
    * @test
    * @group unit
    * @dataProvider methodNames
    */
    function toggle_global_logging_off($name) {
        $before = $this->result;
        $this->log->turn("off all $name");
        call_user_func(array($this->log, $name), $before . 'new');
        $this->assertEquals($before, $this->result);
        $this->log->turn("on all $name");
    }


    function badTurnFormats()
    {
        return array(
            array('f warn'),
            array('on wrn'),
            array('off warn globaly')
        );
    }
    /**
    * @test
    * @group unit
    * @dataProvider badTurnFormats
    * @expectedException InvalidArgumentException
    */
    function wrong_format_exceptions($toggle) {
        $this->log->turn($toggle);
    }

    /**
    * @test
    * @group unit
    */
    function all_level_messages_are_propagated_to_writer() {
        $log = $this->log;
        $log->emergency("message");
        $this->assertEquals('LoggerTest EMERGENCY message', $this->result);
        $log->alert("message");
        $this->assertEquals('LoggerTest ALERT message', $this->result);
        $log->critical("message");
        $this->assertEquals('LoggerTest CRITICAL message', $this->result);
        $log->error("message");
        $this->assertEquals('LoggerTest ERROR message', $this->result);
        $log->notice("message");
        $this->assertEquals('LoggerTest NOTICE message', $this->result);
        $log->warn("message");
        $this->assertEquals('LoggerTest WARNING message', $this->result);
        $log->info("message");
        $this->assertEquals('LoggerTest INFO message', $this->result);
        $log->debug("message");
        $this->assertEquals('LoggerTest DEBUG message', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function object_context_uses_its_class_name() {
        $this->log->info('message');
        $this->assertEquals('LoggerTest INFO message', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function logf_methods_formating() {
        $this->log->debugf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest DEBUG a 1', $this->result);

        $this->log->infof('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest INFO a 1', $this->result);

        $this->log->noticef('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest NOTICE a 1', $this->result);

        $this->log->warnf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest WARNING a 1', $this->result);

        $this->log->errorf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest ERROR a 1', $this->result);

        $this->log->criticalf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest CRITICAL a 1', $this->result);

        $this->log->alertf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest ALERT a 1', $this->result);

        $this->log->emergencyf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest EMERGENCY a 1', $this->result);
    }

}
