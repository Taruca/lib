<?php
include '../../REDTools/REDLog.php';
include '../../database/DatabaseManager.php';
include '../../database/DatabaseConnect.php';
include '../../dataparser/DBSNPParser.php';
include '../../database/TableCreator.php';

$dbsnpPath = 'G:/Taruca/data/dbsnp_138.hg19.vcf';
$con = DatabaseConnect::mysqlConnect();

DBSNPParser::loadDbSNPTable($con,$dbsnpPath);
echo 'success';
?>