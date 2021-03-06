<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../filters/denovo/RepeatRegionsFilter.php';
include '../database/TableCreator.php';
include '../REDTools/REDTools.php';
include '../REDTools/SiteBean.php';

$con = DatabaseConnect::mysqlConnect();
$args = array(0);
$previousTable = "bj22n_etfilter_qcffilter";
$rrFilterName = RepeatRegionsFilter::getName();
$currentTable = "bj22n_qcfilter_" .$rrFilterName;
RepeatRegionsFilter::performRepeatRegionsFilter($con, $previousTable, $currentTable, $args);
?>