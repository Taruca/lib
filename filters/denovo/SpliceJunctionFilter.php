<?php
class SpliceJunctionFilter {
    function __construct() {}

    static function performSpliceJunctionFilter($con, $previousTable, $currentTable, $args) {
        if ($args == null || $args == 0) {
            return;
        } else if (count($args) != 1) {
            REDLog::writeErrLog("Args for Splice Junction Filter are incomplete, please have a check");
        }
        TableCreator::createFilterTable($con, $previousTable, $currentTable);
        REDLog::writeInfoLog("Start performing Splice Junction Filter...");
        $spliceJunctionTable = "splice_junction";
        $edge = (int)$args[0];
        try {
            $sqlClause = "insert into $currentTable select * from $previousTable where not exists (select chrom from
$spliceJunctionTable where ($spliceJunctionTable.type='CDS' and $spliceJunctionTable.chrom=$previousTable.chrom
and (($spliceJunctionTable.begin<$previousTable.pos+$edge and $spliceJunctionTable.begin>$previousTable.pos-$edge)
or ($spliceJunctionTable.end<$previousTable.pos+$edge and $spliceJunctionTable.end>$previousTable.pos-$edge))))";
            $v = mysqli_query($con, $sqlClause);
            if(!$v){
                throw new Exception("Error execute sql clause in performSpliceJunctionFilter");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        REDLog::writeInfoLog("End performing Splice Junction Filter...");
    }

}
?>