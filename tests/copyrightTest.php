<?php

class CopyrightTest extends PHPUnit_Framework_TestCase {

    //
    function dirs_to_parse() {
        return array(
            array(dirname(__DIR__). '/src')
        );
    }

    /**
    * @test
    * @group QA
    * @dataProvider dirs_to_parse
    */
    function some_files_are_missing_the_copyright_statement($dir) {
        $Directory = new RecursiveDirectoryIterator($dir);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, '/\.php$/i', RecursiveRegexIterator::GET_MATCH);
        $result = array();
        $Regex->next();
        while ( $Regex->valid() ) {
            $path = $Regex->getPathname();
            $copy = 'Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)';

            if(!$this->file_contains($path, $copy)) {
                $result[] = $path;
            }
            $Regex->next();
        }
        $this->assertEquals('', implode("\n", $result));
    }

    private function file_contains($path, $str) {
        $handle = fopen($path, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if(strpos($line, $str)) {
                    fclose($handle);
                    return true;
                }
            }
            fclose($handle);
            return false;
        } else {
            syslog(LOG_ERR, 'Cannot open ' . $path);
            return false;
        }
    }
}
