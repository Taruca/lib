<?php
class DNARNAFilter {
    //tested
    function __construct() {}

    static function performDNARNAFilter($con, $previousTable, $currentTable, $args) {
        if ($args == null || count($args) == 0) {
            return;
        } else if (count($args) != 2) {
            REDLog::writeErrLog("Args for DNA-RNA Filter are incomplete, please have a check");
        }
        TableCreator::createFilterTable($con, $previousTable, $currentTable);
        REDLog::writeInfoLog("Start performing DNA-RNA Filter");
        $dnaVcfTable = $args[0];
        $editingType = $args[1];
        $negativeType = REDTools::getNegativeStrandEditingType($editingType);
        try {
            $num1 = substr($editingType, 0, 1);
            $num2 = substr($negativeType, 0, 1);
            $sqlClause = "insert into $currentTable select * from $previousTable where exists (select chrom
from $dnaVcfTable where ($dnaVcfTable.chrom=$previousTable.chrom and $dnaVcfTable.pos=$previousTable.pos and (
$dnaVcfTable.ref='$num1' or $dnaVcfTable.ref='$num2')))";
            $v = mysqli_query($con, $sqlClause);
            if(!$v){
                throw new Exception("Error execute sql clause in performDNARNAFilter");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        REDLog::writeInfoLog("End performing DNA-RNA Filter");
    }

    static function getName() {
        return "drFilter";
    }

}
?>