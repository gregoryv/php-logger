<?php
use gregoryv\logger\State;
require_once 'DataProvider.php';

class StateTest extends \PHPUnit\Framework\TestCase {

    use DataProvider;

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
    */
    function toggle_format($flag, $name) {
        $this->expectException(InvalidArgumentException::class);
        $state = new State();
        $state->toggle($flag, $name);
    }

}
