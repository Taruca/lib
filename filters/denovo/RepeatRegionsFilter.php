<?php
class RepeatRegionsFilter {
//tested
    function __construct(){}

    static function performRepeatRegionsFilter($con, $previousTable, $currentTable, $args) {
        TableCreator::createFilterTable($con, $previousTable, $currentTable);
        REDLog::writeInfoLog("Start performing Repeat Regions Filter");
        $repeatTable = "repeat_masker";
        try {
            $sqlClause1 = "insert into " .$currentTable ." select * from " .$previousTable ." where not exists (select * from "
                .$repeatTable ." where (" .$repeatTable .".chrom= " .$previousTable .".chrom and  " .$repeatTable .".begin<="
                .$previousTable .".pos and " .$repeatTable .".end>=" .$previousTable .".pos)) ";
            $a = mysqli_query($con, $sqlClause1);
            if(!$a){
                throw new Exception("Error execute sqlA clause in performRepeatRegionsFilter");
            }
            REDLog::writeInfoLog("Start finding sites in Alu Regions");
            $tempTable = REDTools::getRandomString(10);
            $sqlClause2 = "create temporary table $tempTable like $currentTable";
            $b = mysqli_query($con, $sqlClause2);
            if(!$b) {
                throw new Exception("Error execute sqlB clause in performRepeatRegionsFilter");
            }
            $sqlClause3 = "insert into  $tempTable select * from $previousTable where exists (select chrom from $repeatTable
where $repeatTable.chrom = $previousTable.chrom and $repeatTable.begin<=$previousTable.pos and
$repeatTable.end>=$previousTable.pos and $repeatTable.type='SINE/Alu')";
            $c = mysqli_query($con, $sqlClause3);
            if(!$c) {
                throw new Exception("Error execute sqlC clause in performRepeatRegionsFilter");
            }
            $sqlClause4 = "update $tempTable set alu='T'";
            $d = mysqli_query($con, $sqlClause4);
            if(!$d) {
                throw new Exception("Error execute sqlD clause in performRepeatRegionsFilter");
            }
            $sqlClause5 = "insert into $currentTable select * from $tempTable";
            $e = mysqli_query($con, $sqlClause5);
            if(!$e) {
                throw new Exception("Error execute sqlE clause in performRepeatRegionsFilter");
            }
            DatabaseManager::deleteTable($con, $tempTable);
            REDLog::writeInfoLog("End finding sites in Alu Regions");
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        REDLog::writeInfoLog("End performing Repeat Regions Filter");
    }

    static function getName() {
        return "rrFilter";
    }
}
?>
