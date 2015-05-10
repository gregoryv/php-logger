<?php
// Copyright (c) 2015 Gregory Vinčić, The MIT License (MIT)
namespace gregoryv\logger;

/**
 * FIFO cache of log messages
 */
class CachedWriter implements PriorityWriterInterface
{
    /**
     * @var array $cache holding the messages
     */
    public $cache;

    private $messageLimit;

    /**
     * @param $messageLimit how many messages to keep in cache
     */
    public function __construct($messageLimit=20)
    {
        $this->cache = [];
        $this->messageLimit = $messageLimit;
    }

    /**
     * Stores messages in the public cache by priority
     */
    public function pwrite($priority, $value='')
    {
        if(sizeof($this->cache) == $this->messageLimit) {
            array_shift($this->cache);
        }
        $this->cache[] = $value;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        if(!is_int($limit)) {
            throw new InvalidArgumentException("limit must be a int");
        }
        if($limit < 1) {
            throw new InvalidArgumentException("limit must be 1 or more");
        }
        $this->resizeCache($limit);
        $this->messageLimit = $limit;
    }

    public function resizeCache($limit)
    {
        while(sizeof($this->cache) != $limit) {
            array_unshift($this->cache);
        }
    }
}
