<?php

$stderr_result = "";
$stdout_result = "";
function myfwrite($fh, $value)
{
    global $stderr_result, $stdout_result;
    if($fh === STDERR) {
        $stderr_result = $value;
        return;
    }
    if($fh === STDOUT) {
        $stdout_result = $value;
        return;
    }
    // Call to original
    return myfwrite($fh, $value);
}

trait fwriteRenameTrait
{
    public static function setupBeforeClass()
    {
        uopz_rename("fwrite", "myfwrite");
    }

    public static function teardownAfterClass()
    {
        uopz_rename("myfwrite", "fwrite");
    }
}
