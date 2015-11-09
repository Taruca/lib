<?php
class RefGeneParser {
    static $dbName = 'REDWeb';

    function __construct() {}

    static function createRefSeqGeneTable($con, $tableName) {
        try {
            $tableLists = DatabaseManager::getCurrentTables($con, self::$dbName);
            $v = in_array($tableName, $tableLists);
            if (!$v) {
                $rs = false;
            }else {
                $rs = true;
            }
            if (!$rs) {
                $columnName = array("bin", "name", "chrom", "strand", "txStart", "txEnd", "cdsStart", "cdsEnd","exonCount",
                    "exonStarts", "exonEnds", "score", "name2", "cdsStartStat", "cdsEndStat", "exonFrames");
                $columnParams = array("int", "varchar(255)", "varchar(255)", "varchar(1)", "int", "int", "int", "int", "int",
                    "longblob", "longblob", "int", "varchar(255)", "varchar(8)", "varchar(8)", "longblob");
                $index = "index(chrom,txStart,txEnd)";
                $a = TableCreator::createReferenceTable($con, $tableName, $columnName, $columnParams, $index);
                if(!$a){
                    throw new Exception("Error create RefSeqGene table");
                }
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function loadRefSeqGeneTable($con, $refSeqGenePath) {
        REDLog::writeInfoLog("Start loading Ref Seq Gene File into database");
        $refseqGeneTableName = "reference_gene";
        if (!DatabaseManager::hasEstablishTable($con, $refseqGeneTableName)) {
            self::createRefSeqGeneTable($con, $refseqGeneTableName);
            try {
                $sqlClause = "load data local infile '" .$refSeqGenePath ."' into table " .$refseqGeneTableName; /*." fields terminated"
                    ."by '\t' lines terminated by '\n'";*/
                /*echo $sqlClause;*/
                $v = mysqli_query($con, $sqlClause);
                if (!$v) {
                    throw new Exception("Error execute sql clause in loadRefSeqGeneTable()");
                }
            } catch (Exception $e) {
                REDLog::writeErrLog($e->getMessage());
            }
        }
        REDLog::writeInfoLog("End loading Ref Seq Gene File into database");
    }

}
?>
