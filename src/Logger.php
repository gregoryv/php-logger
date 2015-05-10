<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;


/**
* Loggers are used to send formated messages to the writers using
* specific log levels.
*
* Default template of the message is
*
*   context( INFO|WARNING|ERROR|DEBUG) message
*/
class Logger
{
    private static $writer;
    private $template;

    /**
     * Constructs a new logger where all messages are prefixed with
     * the context.
     * If the context is an object the class name of that object is used.
     *
     * @param mixed $context string or class
     */
    function __construct($context='')
    {
        if(empty(self::$writer)) {
            self::$writer = new SyslogWriter();
        }
        if(is_object($context)) {
            $context = get_class($context);
        }
        $label = empty($context) ? '' : $context . ' ';
        $this->template = $label . "%s %s";
    }

    /**
     * Set global writer for all your loggers
     *
     * @param PriorityWriterInterface $writer
     */
    public static function setWriter(PriorityWriterInterface $writer)
    {
        self::$writer = $writer;
    }

    /**
     * Write formated INFO level messages
     */
    public function info($value='')
    {
        self::$writer->pwrite(LOG_INFO, sprintf($this->template, 'INFO', $value));
    }

    /**
     * Write formated WARNING level messages
     */
    public function warn($value='')
    {
        self::$writer->pwrite(LOG_WARNING, sprintf($this->template, 'WARNING', $value));
    }

    /**
     * Write formated ERROR level messages
     */
    public function error($value='')
    {
        self::$writer->pwrite(LOG_ERR, sprintf($this->template, 'ERROR', $value));
    }

    /**
     * Write formated DEBUG level messages
     */
    public function debug($value='')
    {
        self::$writer->pwrite(LOG_DEBUG, sprintf($this->template, 'DEBUG', $value));
    }
}
