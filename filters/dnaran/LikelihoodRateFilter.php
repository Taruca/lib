<?php
class LikelihoodRateFilter {

    function __construct() {}

    static function performLikelihoodRateFilter($con, $previousTable, $currentTable, $args) {
        if ($args ==null || count($args) == 0) {
            return;
        } else if (count($args) != 2) {
            REDLog::writeErrLog("Args for Likelihood Rate Test Filter are incomplete, please have a check");
        }
        $dnaVcfTable = $args[0];
        $threshold = (double)($args[1]);
        TableCreator::createFilterTable($con, $previousTable, $currentTable);
        REDLog::writeInfoLog("Start performing Likelihood Rate Test Filter");
        $sqlClause1 = "select $previousTable.chrom,$previousTable.pos,$previousTable.AD,
$dnaVcfTable.qual from $previousTable,$dnaVcfTable where $previousTable.chrom=
$dnaVcfTable.chrom and $previousTable.pos=$dnaVcfTable.pos";
        $rs = DatabaseManager::query1($con, $sqlClause1);
        $i = 0;
        while($row = mysqli_fetch_array($rs)) {
            $chr = (string)$row[0];
            $pos = (int)$row[1];
            $ad = (string)$row[2];
            $qual = (float)$row[3];
            $pb = new SiteBean;
            $pb -> SiteBean1($chr, $pos);
            $pb -> setAd($ad);
            $pb -> setQual($qual);
            $siteBeans[$i] = $pb;
            $i++;
        }
        DatabaseManager::setAutoCommit($con, false);
        $count = 0;
        for ($j = 0; $j < $i; $j++) {
            $str = $siteBeans[$j] -> getAd();
            $section = explode("/", $str);
            $ref = (int)$section[0];
            $alt = (int)$section[1];
            if($ref + $alt > 0) {
                $f_ml = 1.0 * $ref / ($ref + $alt);
                $y = pow($f_ml, $ref) * pow(1 - $f_ml, $alt);
                $y = log($y) / log(10.0);
                $judge = $y + ($siteBeans[$j] -> getQual()) / 10.0;
                if ($judge >= $threshold) {
                    $siteChr = $siteBeans[$j] -> getChr();
                    $sitePos = $siteBeans[$j] -> getPos();
                    $sqlClause2 = "insert into $currentTable select * from $previousTable where chrom='" .$siteChr
                        ."' and pos=" .$sitePos;
                    DatabaseManager::insertClause($con, $sqlClause2);
                    if (++$count % 10000 == 0) {
                        DatabaseManager::commit($con);
                    }
                }
            }
        }
        DatabaseManager::commit($con);
        DatabaseManager::setAutoCommit($con, true);
        REDLog::writeInfoLog("End performing Likelihood Rate Test Filter");
    }

}

?>