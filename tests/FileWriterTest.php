<?php
require_once __DIR__ . '/../vendor/autoload.php';

use gregoryv\logger\FileWriter;

class FileWriterTest extends PHPUnit_Framework_TestCase {

    /**
    * @test
    * @group unit
    */
    function one_file_for_all_levels() {
        $file = '/tmp/gregoryv_logger.txt';
        unlink($file);
        $writer = new FileWriter($file);
        $writer->pwrite(LOG_INFO, '1');
        $writer->pwrite(LOG_WARNING, '2');
        $writer->pwrite(LOG_ERR, '3');
        $writer->pwrite(LOG_DEBUG, '4');

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
    function alternative_log_file($priority, $file) {
        if(is_file($file)) {
            unlink($file);
        }
        $writer = new FileWriter('/tmp/gregoryv_default.txt');
        $writer->useFile($priority, $file);
        $writer->pwrite($priority, '1');

        $result = file_get_contents($file);
        $expected = implode("\n", [1,'']);
        $this->assertEquals($expected, $result);

    }

}
