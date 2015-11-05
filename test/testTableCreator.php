<?php
include '../database/DatabaseConnect.php';
include '../database/TableCreator.php';
include '../database/DatabaseManager.php';
include '../REDTools/REDLog.php';


$con = DatabaseConnect::mysqlConnect();
TableCreator::createFilterTable($con, 'users', 'test');
echo 'success'
?>