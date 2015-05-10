<?php
namespace gregoryv\logger;

class CachedWriter implements PriorityWriterInterface
{
    public $cache, $messageLimit;

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
}
