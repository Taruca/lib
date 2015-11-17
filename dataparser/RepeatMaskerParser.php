<?php
class RepeatMaskerParser {
    //tested
    static $dbName = "REDWeb";

    function __construct() {}

    static function createRepeatRegionsTable($con, $tableName) {
        try {
            $tableLists = DatabaseManager::getCurrentTables($con, self::$dbName);
            $v = in_array($tableName, $tableLists);
            if (!$v) {
                $rs = false;
            }else {
                $rs = true;
            }
            if (!$rs) { //existTable($tableName)
                $columnName = array("chrom", "begin", "end", "type");
                $columnParams = array("varchar(30)", "int", "int", "varchar(40)");
                $index = "index(chrom,begin,end)";
                $v = TableCreator::createReferenceTable($con, $tableName, $columnName, $columnParams, $index);
                if (!$v) {
                    throw new Exception("Error create repeat regions table");
                }
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function loadRepeatTable($con, $repeatPath) {
        REDLog::writeInfoLog("Start loading RepeatMasker file into database");
        $repeatTable = "repeat_masker";
        try {
            if(!DatabaseManager::hasEstablishTable($con, $repeatTable)) {
                self::createRepeatRegionsTable($con, $repeatTable);
                DatabaseManager::setAutoCommit($con, false);
                $count = 0;
                $fp = fopen($repeatPath, 'r');
                fgets($fp);
                fgets($fp);
                fgets($fp);
                while (($line = fgets($fp)) != null) {
                    $line1 = trim($line);
                    $section = explode(" ", preg_replace("/\s(?=\s)/", "\\1", $line1)); # /[\s]+/
                    $sqlClause = "insert into $repeatTable(chrom,begin,end,type) values('$section[4]','$section[5]','$section[6]','$section[10]')";
                    $v = mysqli_query($con, $sqlClause);
                    if (++$count %10000 == 0) {
                        DatabaseManager::commit($con);
                    }
                }
                DatabaseManager::commit($con);
                DatabaseManager::setAutoCommit($con, true);
                if (!$v) {
                    throw new Exception("Error execute sql clause in loadRepeatTable()\n");
                }
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        fclose($fp);
        REDLog::writeInfoLog("End loading RepeatMasker file into database");
    }

}

?>