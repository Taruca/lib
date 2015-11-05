<?php
#include '../REDTools/DatabaseConnect.php';

class DatabaseManager {

    function __construct(){
    }

    static  function setAutoCommit($con,$autoCommit) {
        try {
            $v = mysqli_autocommit($con,$autoCommit);
            if(!$v){
                throw new Exception("Can not set commit automatically.");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function commit($con) {
        try {
            $v = mysqli_commit($con);
            if(!$v){
                throw new Exception("Error commit to database.");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function calRowCount($con, $tableName) {
        $result = mysqli_query($con, "select count(1) from " .$tableName);
        if ($result != null && next($result)) {
            return mysqli_fetch_array($result);
        } else {
            return 0;
        }
    }

    static function hasEstablishTable($con,$darnedTable) {
        try {
            $v = self::calRowCount($con,$darnedTable);
            if ($v > 0) {
                return $v;
            }
            else {
                throw new Exception("Table has been established.");
                return false;
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    /*
     * tested
    */
    static function deleteTable($con,$tableName) {
        try {
            $v = mysqli_query($con, "drop table if exists " .$tableName);
            if(!$v){
                throw new Exception("Error delete table:" .$tableName);
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function insertClause($con, $sqlClause) {
        try {
            $v = mysqli_query($con, $sqlClause);
            if(!$v){
                throw new Exception("Can not insert into data table.");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        return $v;
    }

    static function getCurrentTables($database) {

    }

}

?>