<?php

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

    public function methodNamesAndPrefixes()
    {
        return array(
            array('debug', 'DEBUG'),
            array('info', 'INFO'),
            array('notice', 'NOTICE'),
            array('warn', 'WARNING'),
            array('error', 'ERROR'),
            array('critical', 'CRITICAL'),
            array('alert', 'ALERT'),
            array('emergency', 'EMERGENCY')

        );
    }

    public function fmethodNamesAndPrefixes()
    {
        $a = $this->methodNamesAndPrefixes();
        for ($i=0; $i < count($a); $i++) {
            $a[$i][0] .= 'f';
        }
        return $a;
    }

}
