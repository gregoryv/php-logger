<?php
namespace gregoryv\logger;

/**
 * Responsible for distributing prioritized messages to some media, eg. file
 * or syslog.
 *
 * @see SyslogWriter
 */
interface PriorityWriterInterface
{
    /**
     * @param int $priority eg. LOG_DEBUG, LOG_ERR
     * @param string $message the string to write
     */
    public function pwrite($priority, $message='');
}

