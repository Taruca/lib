<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../dataparser/RNAVCFParser.php';

$vcfPath = 'G:\Taruca\data\BJ22.snvs.hard.filtered.vcf';
$con = DatabaseConnect::mysqlConnect();

RNAVCFParser::parseMultiRNAVCFFile($con,$vcfPath);
echo 'success';
?>