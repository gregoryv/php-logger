<?php
require_once __DIR__ . '/../vendor/autoload.php';

use gregoryv\logger\CachedWriter;

class CachedWriterTest extends PHPUnit_Framework_TestCase {

    function setUp() {

    }

    /**
    * @test
    * @group unit
    */
    function limit_is_respected() {
        $writer = new CachedWriter(2);
        $writer->pwrite(1, 'a');
        $writer->pwrite(1, 'b');
        $writer->pwrite(1, 'c');
        $this->assertEquals($writer->cache[0], 'b');
    }
}