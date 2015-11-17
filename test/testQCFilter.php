<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../filters/denovo/QualityControlFilter.php';
include '../database/TableCreator.php';
include '../REDTools/REDTools.php';
include '../REDTools/SiteBean.php';

$con = DatabaseConnect::mysqlConnect();
$args = array("20", "6");
$previousTable = "bj22n_etfilter";
$etFilterName = QualityControlFilter::getName();
$currentTable = "bj22n_etfilter_" .$etFilterName;
QualityControlFilter::performQualityControlFilter($con, $previousTable, $currentTable, $args);
?>