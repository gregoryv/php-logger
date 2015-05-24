<?php
use gregoryv\logger\State;

class StateTest extends PHPUnit_Framework_TestCase {

    function setUp() {

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
    function toggle_state($name) {
        $state = new State();

        $state->toggle('on', $name);
        $vars = get_object_vars($state);
        $this->assertTrue($vars[$name]);

        $state->toggle('off', $name);
        $vars = get_object_vars($state);
        $this->assertFalse($vars[$name]);
    }


    public function badFlagsAndNames()
    {
        return array(
            array('x', 'info'),
            array('on', 'blah'),
            array('off', 'tjoff'),
            array('off ', 'info'),
            array(' on', 'debug')
        );
    }
    /**
    * @test
    * @group unit
    * @dataProvider badFlagsAndNames
    * @expectedException InvalidArgumentException
    */
    function toggle_format($flag, $name) {
        $state = new State();
        $state->toggle($flag, $name);
    }

}
