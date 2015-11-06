<?php
class DBSNPParser {
    static $dbName = "REDWeb";

    function __construct() {}

    static function createDBSNPTable($con, $tableName) {
        try {
            $tableLists = DatabaseManager::getCurrentTables($con, self::$dbName);
            $v = in_array($tableName, $tableLists);
            if(!$v) {
                $rs = false;
            } else {
                $rs = true;
            }
            if(!$rs) {
                $columnName = array("chrom", "pos");
                $columnParams = array("varchar(30)", "int");
                $index = "index(chrom,pos)";
                $a = TableCreator::createReferenceTable($con, $tableName, $columnName, $columnParams, $index);
                if(!$a){
                    throw new Exception("Error create dbSNP table");
                }
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function loadDbSNPTable($con, $dbSNPPath) {
        REDLog::writeInfoLog("Start loading dbSNP file into database");
        $dbSNPTable = "dbsnp_database";
        try {
            if (!DatabaseManager::hasEstablishTable($con, $dbSNPTable)) {
                self::createDBSNPTable($con, $dbSNPTable);
                $count = 0;
                $fp = fopen($dbSNPPath, 'r');
                while ($line = fgets($fp) != null) {
                    if (strpos($line, "#") === 0) {
                        $count++;
                    } else {
                        break;
                    }
                }
                fclose($fp);
                $sqlClause = "load data local infile '$dbSNPPath' into table $dbSNPTable
				fields terminated by '\t' lines terminated by '\n' IGNORE $count LINES";
                $v = mysqli_query($con, $sqlClause);
                if (!$v) {
                    throw new Exception("Error execute sql clause in loadDbSNPTable()");
                }
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        REDLog::writeInfoLog("End loading dbSNP file into database");
    }

}
?>