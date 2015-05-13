<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;

/**
* FileWriter writes log messages to one or more files
*/
class FileWriter implements SeverityWriterInterface
{

    private $default_fh, $info_fh, $warn_fh, $error_fh, $debug_fh;

    /**
     * @param string $default path to file where all log levels are written by default
     */
    function __construct($default)
    {
        $fh = fopen($default, 'a');
        $this->default_fh = $fh;
        $this->info_fh = $fh;
        $this->warn_fh = $fh;
        $this->error_fh = $fh;
        $this->debug_fh = $fh;
    }

    public function swrite($priority, $value='')
    {
        $fh = $this->selectFileHandle($priority);
        fwrite($fh, $value . "\n");
    }

    /**
     * @param int $priority which level
     * @param string $file path to file
     */
    public function useFile($priority, $file)
    {
        $fh = fopen($file, 'a');
        switch ($priority) {
            case LOG_INFO:
                $this->info_fh = $fh;
                break;
            case LOG_WARNING:
                $this->warn_fh = $fh;
                break;
            case LOG_ERR:
                $this->error_fh = $fh;
                break;
            case LOG_DEBUG:
                $this->debug_fh = $fh;
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid priority %s try LOG_INFO', $priority));
        }
    }

    private function selectFileHandle($priority)
    {
        switch ($priority) {
            case LOG_INFO:
                return $this->info_fh;
            case LOG_WARNING:
                return $this->warn_fh;
            case LOG_ERR:
                return $this->error_fh;
            case LOG_DEBUG:
                return $this->debug_fh;
        }
        return $this->default_fh;
    }

}
