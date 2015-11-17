<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../filters/dnaran/DNARNAFilter.php';
include '../database/TableCreator.php';
include '../REDTools/REDTools.php';
include '../REDTools/SiteBean.php';

$con = DatabaseConnect::mysqlConnect();
$dnavcfTableName = "bj22n_dnavcf";
$args = array($dnavcfTableName, "AG");
$previousTable = "bj22n_sjfilter_dbfilter";
$currentFilterName = DNARNAFilter::getName();
$currentTable = REDTools::getFirstHalfTableName($previousTable) .$currentFilterName;
DNARNAFilter::performDNARNAFilter($con, $previousTable, $currentTable, $args);
?>