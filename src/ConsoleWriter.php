<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;

/**
* ConsoleWriter writes to stderr and stdout depending on severity
*/
class ConsoleWriter implements SeverityWriterInterface
{

    /**
     * If severity is equal or lower than LOG_ERR then the message is written
     * to STDERR, otherwise STDOUT is used.
     */
    public function swrite($severity, $message='')
    {
        if($severity <= LOG_ERR) {
            fwrite(STDERR, $message . "\n");
        } else {
            fwrite(STDOUT, $message . "\n");
        }
    }
}
