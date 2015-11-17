<?php

class EditingTypeFilter {
//tested
    public function __construct() {}

    static function performEditingTypeFilter($con, $previousTable, $currentTable, $args) {
        REDLog::writeInfoLog('Star executing Editing Type Filter');
        TableCreator::createFilterTable($con, $previousTable, $currentTable);
        $refAlt = $args;
        $refAlt2 = REDTools::getNegativeStrandEditingType($refAlt);

        $sql11 = substr($refAlt, 0, 1);
        $sql12 = substr($refAlt, 1);
        $sql21 = substr($refAlt2, 0, 1);
        $sql22 = substr($refAlt2, 1);

        $sql1 = "insert into " .$currentTable ." select * from " .$previousTable ." WHERE REF='$sql11' AND ALT='$sql12' AND GT!='0/0'";

            $v = DatabaseManager::insertClause($con, $sql1);
            if (!$v) {
                REDLog::writeErrLog('There is a syntax error for SQL clause:' .$sql1);
            }


        $sql2 = "insert into " .$currentTable ." select * from " .$previousTable ." WHERE REF='$sql21' AND ALT='$sql22' AND GT!='0/0'";

            $v = DatabaseManager::insertClause($con, $sql2);
            if (!$v) {
                REDLog::writeErrLog('There is a syntax error for SQL clause:' .$sql2);
            }

        REDLog::writeInfoLog('End executing Editing Type Filter');
    }

    static function getName() {
        return "etFilter";
    }
}
?>