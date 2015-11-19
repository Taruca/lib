<?php
include '../database/DatabaseConnect.php';
include '../database/DatabaseManager.php';
include "../REDTools/REDTools.php";

$con = DatabaseConnect::mysqlConnect();
$userid = "1";
$tableName = "testwrite";
REDTools::writeTableIntoDb($con, $userid, $tableName);
echo "end";
?>