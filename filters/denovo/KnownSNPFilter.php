<?php
class KnownSNPFilter {
//tested
    function __construct() {}

    static function performKnownSNPFilter($con, $previousTable, $currentTable, $args) {
        REDLog::writeInfoLog("Start performing Known SNP Filter");
        TableCreator::createFilterTable($con, $previousTable, $currentTable);
        $dbSnpTable = "dbsnp_database";
        try {
            $sqlClause = "insert into $currentTable select * from $previousTable where not exists (select chrom from
$dbSnpTable where ($dbSnpTable.chrom=$previousTable.chrom and $dbSnpTable.pos=$previousTable.pos))";
            $v = mysqli_query($con,$sqlClause);
            if(!$v){
                throw new Exception("Error execute sql clause in performKnownSNPFilter");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        REDLog::writeInfoLog("End performing Known SNP Filter");
    }

    static function getName() {
        return "dbFilter";
    }

}
?>
