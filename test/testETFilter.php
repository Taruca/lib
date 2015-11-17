<?php
include '../REDTools/REDLog.php';
include '../database/DatabaseManager.php';
include '../database/DatabaseConnect.php';
include '../filters/denovo/EditingTypeFilter.php';
include '../database/TableCreator.php';
include '../REDTools/REDTools.php';

$con = DatabaseConnect::mysqlConnect();
$args = "AG";
$previousTable = "bj22n_rnavcf_1";
$etFilterName = EditingTypeFilter::getName();
$currentTable = "bj22n_" .$etFilterName;
EditingTypeFilter::performEditingTypeFilter($con, $previousTable, $currentTable, $args);
?>
