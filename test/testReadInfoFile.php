<?php
include "../REDTools/REDTools.php";
include "../REDTools/REDLog.php";

$dirPath = "../infoFile";
$fileArray = REDTools::readInfoFile($dirPath);
//var_dump($fileArray);
//echo count($fileArray);
echo $fileArray;
?>