<?php
//tested
include '../../REDTools/REDLog.php';
include '../../database/DatabaseManager.php';
include '../../database/DatabaseConnect.php';
include '../../dataparser/GTFParser.php';
include '../../database/TableCreator.php';

$filePath = 'G:/Taruca/data/genes.gtf';
$con = DatabaseConnect::mysqlConnect();

GTFParser::loadSpliceJunctionTable($con, $filePath);
echo 'success';
?>