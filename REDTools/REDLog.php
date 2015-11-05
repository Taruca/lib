<?php
class REDLog {
    static $logType = 3;
    static $errLogPath = '../logs/errLog.txt';
    static $infoLogPath = '../logs/infoLog.txt';

    function __construct() {}

    /*
     * tested
     */
    static function writeErrLog($errInfo) {
        error_log($errInfo .'......' .date('Y-m-d h:i:sa') ."\r\n", self::$logType, self::$errLogPath);
    }

    static function writeInfoLog($runningInfo) {
        error_log($runningInfo .'......' .date('Y-m-d h:i:sa') ."\r\n", self::$logType, self::$infoLogPath);
    }

}

?>

