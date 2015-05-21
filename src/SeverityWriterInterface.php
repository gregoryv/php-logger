<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;

/**
 * Responsible for distributing prioritized messages to some media, eg. file
 * or syslog.
 *
 * @see SyslogWriter
 */
interface SeverityWriterInterface
{
    /**
     * @param int $severity eg. LOG_DEBUG, LOG_ERR
     * @param string $message the string to write
     */
    public function swrite($severity, $message='');
}

