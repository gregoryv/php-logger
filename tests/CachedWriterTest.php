<?php
use gregoryv\logger\CachedWriter;

class CachedWriterTest extends PHPUnit_Framework_TestCase {

    /**
    * @test
    * @group unit
    */
    function limit_is_respected() {
        $writer = new CachedWriter(3);
        $writer->pwrite(1, 'a');
        $writer->pwrite(1, 'b');
        $writer->pwrite(1, 'c');
        $writer->setLimit(2);
        $this->assertEquals($writer->cache[0], 'b');
        $writer->setLimit(1);
        $this->assertEquals($writer->cache[0], 'c');
    }

    /**
    * @test
    * @group unit
    * @expectedException InvalidArgumentException
    */
    function limit_argument_must_be_an_int() {
        $writer = new CachedWriter();
        $writer->setLimit('astring');
    }

    /**
    * @test
    * @group unit
    * @expectedException InvalidArgumentException
    */
    function limit_argument_must_be_larger_than_0() {
        $writer = new CachedWriter();
        $writer->setLimit(0);
    }

}
