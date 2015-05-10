<?php
namespace gregoryv\logger;

/**
* Logger is what you use in your modules to write log messages.
*/
class Logger
{
    private static $writer;
    private $template;

    function __construct($label='')
    {
        if(empty(self::$writer)) {
            self::$writer = new SyslogWriter();
        }
        $label = empty($label) ? '' : $label . ' ';
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

    public function info($value='')
    {
        self::$writer->pwrite(LOG_INFO, sprintf($this->template, 'INFO', $value));
    }

    public function warn($value='')
    {
        self::$writer->pwrite(LOG_WARNING, sprintf($this->template, 'WARNING', $value));
    }

    public function error($value='')
    {
        self::$writer->pwrite(LOG_ERR, sprintf($this->template, 'ERROR', $value));
    }

    public function debug($value='')
    {
        self::$writer->pwrite(LOG_DEBUG, sprintf($this->template, 'DEBUG', $value));
    }
}
