<?php

use gregoryv\logger\ConsoleWriter;
//require_once 'fwriteRenameTrait.php';

class ConsoleWriterTest extends \PHPUnit\Framework\TestCase {

    //use fwriteRenameTrait;

    /**
    * @test
    * @group unit
    */
    function console_writer_writes_to_correct_out() {
        $this->markTestIncomplete("Once uopz is available on travis enable ConsoleWriterTest");
        $writer = new ConsoleWriter();
        $writer->swrite(LOG_INFO, 'message');
        global $stdout_result, $stderr_result;
        $this->assertEquals("message\n", $stdout_result);
        $writer->swrite(LOG_ERR, 'error');
        $this->assertEquals("error\n", $stderr_result);
    }


}
