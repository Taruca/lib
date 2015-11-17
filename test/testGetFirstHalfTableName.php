<?php
include "../REDTools/REDTools.php";
$tableName1 = "1_bj22n_rnavcf_20151117113605am";
$tableName2 = "1_bj22n_rnavcf_etfilter_20151117113905am";

$firstHalf1 = REDTools::getFirstHalfTableName($tableName1);
$firstHalf2 = REDTools::getFirstHalfTableName($tableName2);
echo "$firstHalf1";
echo "<hr>";
echo "$firstHalf2";
?>