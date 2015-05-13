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
     * @param SeverityWriterInterface $writer
     */
    public static function setWriter(SeverityWriterInterface $writer)
    {
        self::$writer = $writer;
    }


    /**
     * 0. Emergency: system is unusable
     */
    public function emergency($value='')
    {
        self::$writer->swrite(LOG_EMERG, sprintf($this->template, 'EMERGENCY', $value));
    }

    /**
     * 1. Alert: action must be taken immediately
     */
    public function alert($value='')
    {
        self::$writer->swrite(LOG_ALERT, sprintf($this->template, 'ALERT', $value));
    }

    /**
     * 2. Critical: critical conditions
     */
    public function critical($value='')
    {
        self::$writer->swrite(LOG_CRIT, sprintf($this->template, 'CRITICAL', $value));
    }

    /**
     * 3. Error: error conditions
     */
    public function error($value='')
    {
        self::$writer->swrite(LOG_ERR, sprintf($this->template, 'ERROR', $value));
    }

    /**
     * 4. Warning: warning conditions
     */
    public function warn($value='')
    {
        self::$writer->swrite(LOG_WARNING, sprintf($this->template, 'WARNING', $value));
    }

    /**
     * 5. Notice: normal but significant condition
     */
    public function notice($value='')
    {
        self::$writer->swrite(LOG_NOTICE, sprintf($this->template, 'NOTICE', $value));
    }

    /**
     * 6. Informational: informational messages
     */
    public function info($value='')
    {
        self::$writer->swrite(LOG_INFO, sprintf($this->template, 'INFO', $value));
    }

    /**
     * 7. Debug: debug-level messages
     */
    public function debug($value='')
    {
        self::$writer->swrite(LOG_DEBUG, sprintf($this->template, 'DEBUG', $value));
    }
}
