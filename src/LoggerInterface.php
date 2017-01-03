<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;


/**
 * LoggerInterface defines methods for level specific loggin
 */
interface LoggerInterface
{

    /**
     * Debug (severity 7): debug-level messages
     */
    public function debug($value='');

    /**
     * Same as debug(sprintf($format, $args...))
     */
    public function debugf();

    /**
     * Informational (severity 6): informational messages
     */
    public function info($value='');

    /**
     * Same as info(sprintf($format, $args...))
     */
    public function infof();

    /**
     * Notice (severity 5): normal but significant condition
     */
    public function notice($value='');

    /**
     * Same as notice(sprintf($format, $args...))
     */
    public function noticef();

    /**
     * Warning (severity 4): warning conditions
     */
    public function warn($value='');

    /**
     * Same as warn(sprintf($format, $args...))
     */
    public function warnf();

    /**
     * Error (severity 3): error conditions
     */
    public function error($value='');

    /**
     * Same as error(sprintf($format, $args...))
     */
    public function errorf();

    /**
     * Critical (severity 2): critical conditions
     */
    public function critical($value='');

    /**
     * Same as critical(sprintf($format, $args...))
     */
    public function criticalf();

    /**
     * Alert (severity 1): action must be taken immediately
     */
    public function alert($value='');

    /**
     * Same as alert(sprintf($format, $args...))
     */
    public function alertf();

    /**
     * Emergency (severity 0): system is unusable
     */
    public function emergency($value='');

    /**
     * Same as emergency(sprintf($format, $args...))
     */
    public function emergencyf();

}
