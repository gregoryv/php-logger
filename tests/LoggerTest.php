<?php
use gregoryv\logger\Logger;
use gregoryv\logger\SeverityWriterInterface;


class LoggerTest extends PHPUnit_Framework_TestCase implements SeverityWriterInterface {

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
        $this->log->turn("off $name");
        $before = $this->result;
        call_user_func(array($this->log, $name), $before . '..');
        $this->assertEquals($before, $this->result);
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
    function debugf() {
        $this->log->debugf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest DEBUG a 1', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function infof() {
        $this->log->infof('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest INFO a 1', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function noticef() {
        $this->log->noticef('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest NOTICE a 1', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function warnf() {
        $this->log->warnf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest WARNING a 1', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function errorf() {
        $this->log->errorf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest ERROR a 1', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function criticalf() {
        $this->log->criticalf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest CRITICAL a 1', $this->result);
    }

    /**
    * @test
    * @group unit
    */
    function alertf() {
        $this->log->alertf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest ALERT a 1', $this->result);
    }

     /**
    * @test
    * @group unit
    */
    function emergencyf() {
        $this->log->emergencyf('%s %s', 'a', 1);
        $this->assertEquals('LoggerTest EMERGENCY a 1', $this->result);
    }

}
