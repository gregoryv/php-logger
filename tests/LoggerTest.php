<?php
use gregoryv\logger\Logger;
use gregoryv\logger\SeverityWriterInterface;
require_once 'DataProvider.php';
require_once 'fwriteRenameTrait.php';

class LoggerTest extends PHPUnit_Framework_TestCase implements SeverityWriterInterface {
    use DataProvider, fwriteRenameTrait;

    private $result;

    public function swrite($severity, $message='')
    {
        $this->result = $message;
    }

    public function setUp()
    {
        $this->log = new Logger($this);
        Logger::setWriter($this);
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
    * @dataProvider methodNamesAndPrefixes
    */
    function all_level_messages_are_propagated_to_writer($name, $prefix) {
        $log = $this->log;
        call_user_func(array($this->log, $name), 'message');
        $this->assertEquals("LoggerTest $prefix message", $this->result);
    }


    /**
    * @test
    * @group unit
    * @dataProvider fmethodNamesAndPrefixes
    */
    function logf_methods_formating($name, $prefix) {
        $log = $this->log;
        call_user_func_array(array($this->log, $name), array('%s %s', 'a', 1));
        $this->assertEquals("LoggerTest $prefix a 1", $this->result);
    }

}
