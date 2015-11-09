<?php

include '../../REDTools/REDLog.php';
include '../../database/DatabaseManager.php';
include '../../database/DatabaseConnect.php';
include '../../dataparser/RefGeneParser.php';
include '../../database/TableCreator.php';

$dbsnpPath = 'G:/Taruca/data/BJ22_sites.hard.filtered.vcf';
$con = DatabaseConnect::mysqlConnect();

RefGeneParser::loadRefSeqGeneTable($con, $dbsnpPath);
echo 'success';
?>
