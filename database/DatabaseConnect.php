<?php
    
class DatabaseConnect {
    protected static $con;
    protected static $memory_limit = "1000M";
    protected static $max_execution_time = '0';
    protected static $db_host = 'localhost';
    protected static $db_username = 'root';
    protected static $db_password = '123';
    protected static $db_name = 'redweb';

    function __construct($memory_limit, $max_execution_time, $db_host, $db_username, $db_password, $db_name) {
        $this->memory_limit = $memory_limit;
        $this->max_execution_time = $max_execution_time;
        $this->db_host = $db_host;
        $this->db_username = $db_username;
        $this->db_password = $db_password;
        $this->db_name = $db_name;
        ini_set("memory_limit",$memory_limit);
        ini_set('max_execution_time', $max_execution_time);
    }

    /*
     * tested
    */
    static function mysqlConnect() {
        $db_attribute[0] = self::$db_host;
        $db_attribute[1] = self::$db_username;
        $db_attribute[2] = self::$db_password;
        $db_attribute[3] = self::$db_name;


        $con = mysqli_connect($db_attribute[0], $db_attribute[1], $db_attribute[2]);
        mysqli_select_db($con, $db_attribute[3]) or die ('Can not select database:' .$db_attribute[3]);
        return $con;
    }

    static function getDbHost() {
        return self::$db_host;
    }

    static function getDbUsername() {
        return self::$db_username;
    }

    static function getDbPassword() {
        return self::$db_password;
    }

    static function getDbName() {
        return self::$db_name;
    }
}

?>