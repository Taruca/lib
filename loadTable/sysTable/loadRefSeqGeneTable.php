<?php

include '../../REDTools/REDLog.php';
include '../../database/DatabaseManager.php';
include '../../database/DatabaseConnect.php';
include '../../dataparser/RefGeneParser.php';
include '../../database/TableCreator.php';

$filePath = 'G:/Taruca/data/BJ22_sites.hard.filtered.vcf';
$con = DatabaseConnect::mysqlConnect();

RefGeneParser::loadRefSeqGeneTable($con, $filePath);
echo 'success';
?>
