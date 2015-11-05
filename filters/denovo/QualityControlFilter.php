<?php
class QualityControlFilter {

    function __construct() {}

    static function performQualityControlFilter($con, $previousTable, $currentTable, $args) {
        $COMMIT_COUNTS_PER_ONCE = 10000;
        if ($args == null || count($args) == 0) {
            return;
        } elseif (count($args) != 2) {
            REDLog::writeErrLog("Args for Quality Control Filter are incomplete, please have a check");
        }
        $quality = (double)($args[0]);
        $depth = (int)($args[1]);
        TableCreator::createFilterTable($con, $previousTable, $currentTable);
        REDLog::writeInfoLog("Start performing Quality Control Filter");
        try {
            $count = 0;
            $str = array("CHROM", "POS", "AD");
            $rs = DatabaseManager::query2($con, $previousTable, $str, null, null);
            $i = 0;
            while($row = mysqli_fetch_array($rs)) {
                if($row[2] != null) {
                    $siteBean = new SiteBean;
                    $siteBean->SiteBean1($row[0], $row[1]);
                    $siteBean->setAd($row[2]);
                    $siteBeans[$i] = $siteBean;
                    $i = $i + 1;
                }
            }
            DatabaseManager::setAutoCommit($con, false);
            for ($j = 0; $j < $i; $j++) {
                $str = $siteBeans[$j]->getAd();
                $section = explode("/", $str);
                $ref_n = (int)($section[0]);
                $alt_n = (int)($section[1]);
                $pos = $siteBeans[$j]->getPos();
                $chr = $siteBeans[$j]->getChr();
                if ($ref_n + $alt_n >=$depth) {
                    $sqlClause = "insert into " .$currentTable ." (select * from " .$previousTable ." where filter='PASS' and pos=$pos and qual>=" .$quality ." and chrom='" .$chr ."')";
                    $v = mysqli_query($con, $sqlClause);
                    if (++$count % $COMMIT_COUNTS_PER_ONCE == 0) {
                        DatabaseManager::commit($con);
                    }
                }
            }
            DatabaseManager::commit($con);
            DatabaseManager::setAutoCommit($con, true);
            if(!$v){
                throw new Exception("Error execute sql clause in QualityControlFilter:performFilter()");
            }
        } catch (Exception $e) {
            REDLog::writeErrLog($e->getMessage());
        }
        REDLog::writeInfoLog("End performing Quality Control Filter");
    }

    static function getQCFName() {
        return "qcfFilter";
    }
}
?>