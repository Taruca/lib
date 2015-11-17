<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../filters/denovo/KnownSNPFilter.php';
include '../database/TableCreator.php';
include '../REDTools/REDTools.php';
include '../REDTools/SiteBean.php';

$con = DatabaseConnect::mysqlConnect();
$args = array(0);
$previousTable = "bj22n_rrfilter_sjfilter";
$currentFilterName = KnownSNPFilter::getName();
$currentTable = REDTools::getFirstHalfTableName($previousTable) .$currentFilterName;
KnownSNPFilter::performKnownSNPFilter($con, $previousTable, $currentTable, $args);
?>