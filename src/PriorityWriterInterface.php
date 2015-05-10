<?php
namespace gregoryv\logger;

interface PriorityWriterInterface
{
    /**
     * @param int $priority eg. LOG_DEBUG, LOG_ERR
     * @param string $message the string to write
     */
    public function pwrite($priority, $message='');
}

