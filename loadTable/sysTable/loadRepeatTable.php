<?php
//tested
include '../../REDTools/REDLog.php';
include '../../database/DatabaseManager.php';
include '../../database/DatabaseConnect.php';
include '../../dataparser/RepeatMaskerParser.php';
include '../../database/TableCreator.php';

$filePath = 'G:/Taruca/data/hg19.fa.out';
$con = DatabaseConnect::mysqlConnect();

RepeatMaskerParser::loadRepeatTable($con, $filePath);
echo 'success';
?>