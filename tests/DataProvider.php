<?php

/**
*
*/
trait DataProvider
{

    public function methodNames()
    {
        return array(
            array('debug'),
            array('info'),
            array('notice'),
            array('warn'),
            array('error'),
            array('critical'),
            array('alert'),
            array('emergency')
        );
    }
}
