<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../filters/dnaran/LikelihoodRateFilter.php';
include '../database/TableCreator.php';
include '../REDTools/REDTools.php';
include '../REDTools/SiteBean.php';

$con = DatabaseConnect::mysqlConnect();
$dnavcfTableName = "bj22n_dnavcf";
$args = array($dnavcfTableName, "4");
$previousTable = "bj22n_dbfilter_drfilter";
$currentFilterName = LikelihoodRateFilter::getName();
$currentTable = REDTools::getFirstHalfTableName($previousTable) .$currentFilterName;
LikelihoodRateFilter::performLikelihoodRateFilter($con, $previousTable, $currentTable, $args);
?>