<?php
namespace gregoryv\logger;

/**
* SyslogWriter uses syslog() to write messages
*/
class SyslogWriter implements PriorityWriterInterface
{

    public function pwrite($priority, $message='')
    {
        syslog($priority, $message);
    }
}
