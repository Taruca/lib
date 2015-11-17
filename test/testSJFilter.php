<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../filters/denovo/SpliceJunctionFilter.php';
include '../database/TableCreator.php';
include '../REDTools/REDTools.php';
include '../REDTools/SiteBean.php';

$con = DatabaseConnect::mysqlConnect();
$args = array("2");
$previousTable = "bj22n_qcfilter_rrfilter";
$currentFilterName = SpliceJunctionFilter::getName();
$currentTable = REDTools::getFirstHalfTableName($previousTable) .$currentFilterName;
SpliceJunctionFilter::performSpliceJunctionFilter($con, $previousTable, $currentTable, $args);
?>