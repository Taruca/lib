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
}
?>