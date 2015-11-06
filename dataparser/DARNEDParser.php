<?php
class DARNEDParser {

    function __construct() {}

    static function createDARNEDTable($con, $tableName) {
        try {
            $tableLists = DatabaseManager::getCurrentTables($con, "taruca");
            $v = in_array($tableName, $tableLists);
            if (!$v) {
                $rs = false;
            }else {
                $rs = true;
            }
            if (!$rs) {
                $columnName = array("chrom", "coordinate", "strand", "inchr", "inrna");
                $columnParams = array("varchar(30)","int", "varchar(5)", "varchar(5)", "varchar(5)");
                $index = "index(chrom,coordinate)";
                $a = TableCreator::createReferenceTable($con, $tableName, $columnName, $columnParams, $index);
                if (!$a) {
                    throw new Exception("Error create DNRNED table");
                }
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
    }

    static function loadDarnedTable($con, $darnedPath) {
        REDLog::writeInfoLog("Start loading DARNED file into database");
        $darnedTable = "darned_database";
        if(!DatabaseManager::hasEstablishTable($con, $darnedTable)) {
            self::createDARNEDTable($con, $darnedTable);
            try {
                $count = 0;
                DatabaseManager::setAutoCommit($con, false);
                $fp = fopen($darnedPath, 'r');
                fgets($fp);
                while (($line = fgets($fp)) != null) {
                    $line1 = trim($line);
                    $section = explode("\t", $line1);
                    $stringBulider = "insert into " .$darnedTable ."(chrom,coordinate,strand,inchr,inrna) values(";
                    for ($i = 0; $i < 5; $i++) {
                        if ($i == 0) {
                            $stringBulider = $stringBulider ."'chr" .$section[$i] ."',";
                        } else if ($i == 4) {
                            $sec = str_replace("I", "G", $section[$i]);
                            $stringBulider = $stringBulider ."'" .$sec ."'";
                        } else if ($i == 1) {
                            $stringBulider = $stringBulider .$section[$i] .",";
                        } else {
                            $stringBulider = $stringBulider ."'" .$section[$i] ."',";
                        }
                    }
                    $stringBulider = $stringBulider .")";
                    $v = mysqli_query($con, $stringBulider);
                    if(!$v){
                        throw new Exception("Error execute sql clause in loadDarnedTable()");
                    }
                    if (++$count % 10000 == 0) {
                        DatabaseManager::commit($con);
                    }
                    DatabaseManager::commit($con);
                    DatabaseManager::setAutoCommit($con, true);
                }
            } catch (Exception $e) {
                REDLog::writeErrLog($e->getMessage());
            }
        }
        REDLog::writeInfoLog("End loading DARNED file into database");
        
    }

}
?>