<?php
class TableCreator {

    function __construct(){
    }

    /*
     * tested
    */
    static function createFilterTable($con,$refTable, $tableName) {
        try {
            DatabaseManager::deleteTable($con, $tableName);
            $sqlClause = "create table " .$tableName ." like " .$refTable;
            $v = mysqli_query($con, $sqlClause);
            if(!$v){
                throw new Exception("There is a syntax error for SQL clause:" .$sqlClause);
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function createFisherExactTestTable($con, $refTable, $darnedResultTable) {
        DatabaseManager::deleteTable($con, $darnedResultTable);
        self::createFilterTable($con, $refTable, $darnedResultTable);
        try {
            $v = mysqli_query($con, "alter table " .$darnedResultTable ." add level float,add pvalue float,add fdr float");
            if(!$v){
                throw new Exception("Can not create Fisher Exact Test Table.");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function createReferenceTable($con, $tableName, $columnNames, $columnParams, $index) {
        if($columnNames == null || $columnParams == null || count($columnNames) == 0 || count($columnNames) != count($columnParams)) {
            REDLog::writeErrLog("Column names and column parameters can not be null or zero-length");
        }
        $stringBuilder = "create table if not exists $tableName($columnNames[0] $columnParams[0]";
        for($i = 1, $len = count($columnNames); $i < $len; $i++) {
            $stringBuilder = $stringBuilder .", $columnNames[$i] $columnParams[$i]";
        }
        $stringBuilder = $stringBuilder .",$index)";
        try {
            $v = mysqli_query($con, $stringBuilder);
            if(!$v){
                throw new Exception("There is a syntax error for SQL clause: $stringBuilder");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        return $v;
    }

}
?>