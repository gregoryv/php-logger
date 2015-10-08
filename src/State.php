<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;

/**
* Holds state of logging levels
*/
class State
{
    public $debug = true;
    public $info = true;
    public $notice = true;
    public $warn = true;
    public $error = true;
    public $critical = true;
    public $alert = true;
    public $emergency = true;

    /**
     * Sets the named attribute to true or false
     *
     * @param string $flag (on|off)
     * @param string $name (debug|info|notice|warn|error|critical|alert|emergency)
     * @throws InvalidArgumentException on badly formated $flag or $name
     */
    public function toggle($flag, $name)
    {
        switch ($flag) {
            case 'on':
                $onoff = true;
                break;
            case 'off':
                $onoff = false;
                break;
            default:
                throw new \InvalidArgumentException("Flag must be 'on' or 'off'");
        }

        switch ($name) {
            case 'debug':
                $this->debug = $onoff;
                break;
            case 'info':
                $this->info = $onoff;
                break;
            case 'notice':
                $this->notice = $onoff;
                break;
            case 'warn':
                $this->warn = $onoff;
                break;
            case 'error':
                $this->error = $onoff;
                break;
            case 'critical':
                $this->critical = $onoff;
                break;
            case 'alert':
                $this->alert = $onoff;
                break;
            case 'emergency':
                $this->emergency = $onoff;
                break;
            default:
                throw new \InvalidArgumentException("Name must be on (debug|info|notice|warn|error|critical|alert|emergency)");
        }
    }
}
