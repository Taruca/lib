<?php
class executeFilters {
    function __construct() {}

    static function executeFilters() {
        $infoPath = "../infoFile";
        if(($lineArray = REDTools::readInfoFile($infoPath)) != false) {
            $con = DatabaseConnect::mysqlConnect();
            $userid = $lineArray[0];
            $rnaVcfName = $lineArray[1];
            $dnaVcfName = $lineArray[2];
            $etArgs = $lineArray[3];
            $qcArray = explode('/', $lineArray[4]);
            $qcArgs = array($qcArray[0], $qcArray[1]);
            $rrArgs = array(0);
            $sjArgs = array("2");
            $ksArgs = array(0);
            $drArgs = array();
            $lrArgs = array();
            $storgePath = "G:/Taruca/data/";
            $rnaVcfFilePath = $storgePath .$rnaVcfName;
            $dnaVcfFilePath = $storgePath .$dnaVcfName;

            if($rnaVcfName !== "null") {
                //denove mode
                //load RNAVcfFile
                $rnaVcfTableNameArray = RNAVCFParser::parseMultiRNAVCFFile($con, $rnaVcfFilePath, $userid);
                if(count($rnaVcfTableNameArray) != 0) {
                    foreach ($rnaVcfTableNameArray as $rnaVcfTableName) {
                        $etTableName = REDTools::getFirstHalfTableName($rnaVcfTableName) .EditingTypeFilter::getName() ."_" .date("Ymdhisa");
                        EditingTypeFilter::performEditingTypeFilter($con, $rnaVcfTableName, $etTableName, $etArgs);

                        $qcTableName = REDTools::getFirstHalfTableName($etTableName) .QualityControlFilter::getName() ."_" .date("Ymdhisa");
                        QualityControlFilter::performQualityControlFilter($con, $etTableName, $qcTableName, $qcArgs);

                        $rrTableName = REDTools::getFirstHalfTableName($qcTableName) .RepeatRegionsFilter::getName() ."_" .date("Ymdhisa");
                        RepeatRegionsFilter::performRepeatRegionsFilter($con, $qcTableName, $rrTableName, $rrArgs);

                        $sjTableName = REDTools::getFirstHalfTableName($rrTableName) .SpliceJunctionFilter::getName() ."_" .date("Ymdhisa");
                        SpliceJunctionFilter::performSpliceJunctionFilter($con, $rrTableName, $sjTableName, $sjArgs);

                        $ksTableName = REDTools::getFirstHalfTableName($sjTableName) .KnownSNPFilter::getName() ."_" .date("Ymdhisa");
                        KnownSNPFilter::performKnownSNPFilter($con, $sjTableName, $ksTableName, $ksArgs);

                    }

                } else {
                    REDLog::writeErrLog("There is no rnaVcfTables");
                }

            } elseif($dnaVcfName !== "null") {
                //dnarna mode
                $dnaVcfTableArrat = DNAVCFParser::parseMultiDNAVCFFile($con, $dnaVcfFilePath, $userid);

            }

        } else {
            //sleep 10 minute，20s to test
            sleep(20);
            self::executeFilters();
        }

    }

}


?>