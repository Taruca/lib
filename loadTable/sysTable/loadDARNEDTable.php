<?php

include '../../REDTools/REDLog.php';
include '../../database/DatabaseManager.php';
include '../../database/DatabaseConnect.php';
include '../../dataparser/DARNEDParser.php';
include '../../database/TableCreator.php';

$dbsnpPath = 'G:/Taruca/data/hg19_darned.txt';
$con = DatabaseConnect::mysqlConnect();

DARNEDParser::loadDarnedTable($con, $dbsnpPath);
echo 'success';
?>

