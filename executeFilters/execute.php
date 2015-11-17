<?php
include "../database/DatabaseConnect.php";
include "../database/DatabaseManager.php";
include "../database/TableCreator.php";

include "../dataparser/DNAVCFParser.php";
include "../dataparser/RNAVCFParser.php";

include "../filters/denovo/EditingTypeFilter.php";
include "../filters/denovo/KnownSNPFilter.php";
include "../filters/denovo/QualityControlFilter.php";
include "../filters/denovo/RepeatRegionsFilter.php";
include "../filters/denovo/SpliceJunctionFilter.php";
include "../filters/dnaran/DNARNAFilter.php";
include "../filters/dnaran/LikelihoodRateFilter.php";

include "../REDTools/REDLog.php";
include "../REDTools/REDTools.php";
include "../REDTools/SiteBean.php";

$infoPath = "../infoFile";

if(REDTools::readInfoFile($infoPath) != false) {


} else {

}


?>