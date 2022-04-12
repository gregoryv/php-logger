<?php
require_once __DIR__ . '/../vendor/autoload.php';

use gregoryv\logger\FileWriter;

class FileWriterTest extends \PHPUnit\Framework\TestCase {

    /**
    * @test
    * @group unit
    */
    function one_file_for_all_levels() {
        $file = '/tmp/gregoryv_logger.txt';
        if(is_file($file)) {
            unlink($file);
        }
        $writer = new FileWriter($file);
        $writer->swrite(LOG_INFO, '1');
        $writer->swrite(LOG_WARNING, '2');
        $writer->swrite(LOG_ERR, '3');
        $writer->swrite(LOG_DEBUG, '4');

        $result = file_get_contents($file);
        $expected = implode("\n", [1,2,3,4,'']);
        $this->assertEquals($expected, $result);
    }

    public function priorityFiles()
    {
        return [
            [LOG_INFO, '/tmp/gregoryv_info.log'],
            [LOG_WARNING, '/tmp/gregoryv_warn.log'],
            [LOG_ERR, '/tmp/gregoryv_error.log'],
            [LOG_DEBUG, '/tmp/gregoryv_debug.log']
        ];
    }

    /**
    * @test
    * @group unit
    * @dataProvider priorityFiles
    */
    function alternative_log_file($severity, $file) {
        if(is_file($file)) {
            unlink($file);
        }
        $writer = new FileWriter('/tmp/gregoryv_default.txt');
        $writer->useFile($severity, $file);
        $writer->swrite($severity, '1');

        $result = file_get_contents($file);
        $expected = implode("\n", [1,'']);
        $this->assertEquals($expected, $result);
    }

    /**
    * @test
    * @group unit
    * @expectedException InvalidArgumentException
    */
    function setting_unknown_priority_is_invalid() {
        $writer = new FileWriter('/tmp/gregoryv_default.txt');
        $writer->useFile(99, '/tmp/gregoryv_idontknow.txt');
    }

    /**
    * @test
    * @group unit
    */
    function unknown_priority_swrite_to_default() {
        $file = '/tmp/gregoryv_default.txt';
        if(is_file($file)) {
            unlink($file);
        }
        $writer = new FileWriter($file);
        $writer->swrite(99, 'something');
        $result = file_get_contents($file);
        $this->assertEquals("something\n", $result);

    }

}
