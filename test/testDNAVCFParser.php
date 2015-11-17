<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../dataparser/DNAVCFParser.php';

$vcfPath = 'G:\Taruca\data\BJ22_sites.hard.filtered.vcf';
$con = DatabaseConnect::mysqlConnect();

$tableName = DNAVCFParser::parseMultiDNAVCFFile($con, $vcfPath);
var_dump($tableName);
?>