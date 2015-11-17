<?php
class GTFParser {
    //tested
    static $dbName = "REDWeb";

    function __construct() {}

    static function createSpliceJunctionTable($con, $tableName) {
        try {
            $tableLists = DatabaseManager::getCurrentTables($con, self::$dbName);
            $v = in_array($tableName, $tableLists);
            if (!$v) {
                $rs = false;
            }else {
                $rs = true;
            }
            if (!$rs) { //existTable($tableName)
                $columnName = array("chrom", "ref", "type", "begin", "end", "score", "strand", "frame", "info");
                $columnParams = array("varchar(30)", "varchar(30)", "varchar(10)", "int", "int", "float(8,6)", "varchar(1)", "varchar(1)", "varchar(100)");
                $index = "index(chrom,type)";
                $v = TableCreator::createReferenceTable($con, $tableName, $columnName, $columnParams, $index);
                if (!$v) {
                    throw new Exception("Error create Splice Junction table");
                }
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function loadSpliceJunctionTable($con, $spliceJunctionPath) {
        REDLog::writeInfoLog("Start loading Gene Annotation File into database");
        $spliceJunctionTable = "splice_junction";
        if(!DatabaseManager::hasEstablishTable($con, $spliceJunctionTable)) {
            self::createSpliceJunctionTable($con, $spliceJunctionTable);
            try {
                $sqlClause = "load data local infile '$spliceJunctionPath' into table $spliceJunctionTable";
                /*fields terminated by '\t' lines terminated by '\n'*/
                $v = mysqli_query($con, $sqlClause);
                if (!$v) {
                    throw new Exception("Error execute sql clause in loadSpliceJunctionTable()");
                }
            } catch (Exception $e) {
                REDLog::writeErrLog($e->getMessage());
            }
        }
        REDLog::writeInfoLog("End loading Gene Annotation File into database");
    }

}

?>