<?php
class REDLog {
    static $logType = 3;
    static $errLogPath = 'E:/wamp/www/workspace/lib/logs/errLog.txt';
    static $infoLogPath = 'E:/wamp/www/workspace/lib/logs/infoLog.txt';

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

