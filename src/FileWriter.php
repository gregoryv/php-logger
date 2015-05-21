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

    public function swrite($severity, $value='')
    {
        $fh = $this->selectFileHandle($severity);
        fwrite($fh, $value . "\n");
    }

    /**
     * @param int $severity which level
     * @param string $file path to file
     */
    public function useFile($severity, $file)
    {
        $fh = fopen($file, 'a');
        switch ($severity) {
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
                throw new \InvalidArgumentException(sprintf('Invalid priority %s try LOG_INFO', $severity));
        }
    }

    private function selectFileHandle($severity)
    {
        switch ($severity) {
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
