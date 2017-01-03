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
class Logger implements LoggerInterface
{
    private static $writer, $console;
    private $template;
    // Holds severity state, global default for all loggers
    private static $SIEVE;
    private $sieve; // local to this logger

    /**
     * Constructs a new logger where all messages are prefixed with
     * the context.
     * If the context is an object the class name of that object is used.
     *
     * @param mixed $context string or class
     */
    function __construct($context='')
    {
        if(!isset(self::$writer)) {
            self::$writer = new SyslogWriter();
        }
        if(!isset(self::$console)) {
            self::$console = new ConsoleWriter();
        }
        if(is_object($context)) {
            $context = get_class($context);
        }
        if(empty(self::$SIEVE)) {
            self::$SIEVE = new State();
        }
        $label = empty($context) ? '' : $context . ' ';
        $this->template = $label . "%s %s";
        $this->sieve = clone Logger::$SIEVE;
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
     * Sets logging state of the given severity level in a readable format
     *
     * @example $log->turn('on debug');
     * @example $log->turn('off all warn');
     *
     * @param string $toggle format: (on|off) [all] (debug|info|notice|warn|error|critical|alert|emergency)
     */
    public function turn($toggle)
    {
        if(preg_match_all('/^(on|off) (all)?\s?(debug|info|notice|warn|error|critical|alert|emergency)$/', $toggle, $matches)) {
            $flag = $matches[1][0];
            $all = $matches[2][0];
            $name = $matches[3][0];
            $this->sieve->toggle($flag, $name);
            if($all === 'all') {
                self::$SIEVE->toggle($flag, $name);
            }
        } else {
            throw new \InvalidArgumentException("Invalid format: $toggle");
        }
    }


    /**
     * Debug (severity 7): debug-level messages
     */
    public function debug($value='')
    {
        if($this->sieve->debug) {
            self::$writer->swrite(LOG_DEBUG, sprintf($this->template, 'DEBUG', $value));
        }
    }

    /**
     * Same as debug(sprintf($format, $args...))
     */
    public function debugf()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->debug(vsprintf($format, $args));
    }

    /**
     * Informational (severity 6): informational messages
     */
    public function info($value='')
    {
        if($this->sieve->info) {
            self::$writer->swrite(LOG_INFO, sprintf($this->template, 'INFO', $value));
        }
    }

    /**
     * Same as info(sprintf($format, $args...))
     */
    public function infof()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->info(vsprintf($format, $args));
    }

    /**
     * Notice (severity 5): normal but significant condition
     */
    public function notice($value='')
    {
        if($this->sieve->notice) {
            self::$writer->swrite(LOG_NOTICE, sprintf($this->template, 'NOTICE', $value));
        }
    }

    /**
     * Same as notice(sprintf($format, $args...))
     */
    public function noticef()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->notice(vsprintf($format, $args));
    }

    /**
     * Warning (severity 4): warning conditions
     */
    public function warn($value='')
    {
        if($this->sieve->warn) {
            self::$writer->swrite(LOG_WARNING, sprintf($this->template, 'WARNING', $value));
        }
    }

    /**
     * Same as warn(sprintf($format, $args...))
     */
    public function warnf()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->warn(vsprintf($format, $args));
    }

    /**
     * Error (severity 3): error conditions
     */
    public function error($value='')
    {
        if($this->sieve->error) {
            self::$writer->swrite(LOG_ERR, sprintf($this->template, 'ERROR', $value));
        }
    }

    /**
     * Same as error(sprintf($format, $args...))
     */
    public function errorf()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->error(vsprintf($format, $args));
    }

    /**
     * Critical (severity 2): critical conditions
     */
    public function critical($value='')
    {
        if($this->sieve->critical) {
            self::$writer->swrite(LOG_CRIT, sprintf($this->template, 'CRITICAL', $value));
        }
    }

    /**
     * Same as critical(sprintf($format, $args...))
     */
    public function criticalf()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->critical(vsprintf($format, $args));
    }

    /**
     * Alert (severity 1): action must be taken immediately
     */
    public function alert($value='')
    {
        if($this->sieve->alert) {
            self::$writer->swrite(LOG_ALERT, sprintf($this->template, 'ALERT', $value));
        }
    }

    /**
     * Same as alert(sprintf($format, $args...))
     */
    public function alertf()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->alert(vsprintf($format, $args));
    }

    /**
     * Emergency (severity 0): system is unusable
     */
    public function emergency($value='')
    {
        if($this->sieve->emergency) {
            self::$writer->swrite(LOG_EMERG, sprintf($this->template, 'EMERGENCY', $value));
        }
    }

    /**
     * Same as emergency(sprintf($format, $args...))
     */
    public function emergencyf()
    {
        $args = func_get_args();
        $format = array_shift($args);
        $this->emergency(vsprintf($format, $args));
    }

}
