<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;

/**
* SyslogWriter uses syslog() to write messages
*/
class SyslogWriter implements SeverityWriterInterface
{

    public function swrite($priority, $message='')
    {
        syslog($priority, $message);
    }
}
