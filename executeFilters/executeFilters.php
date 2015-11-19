<?php
class executeFilters {
    function __construct() {}

    static function executeFilters() {
        $startInfo = "RNA Editing Detector start\r\n" ."--------------------------\r\n" ."--------------------------\r\n";
        REDLog::writeInfoLog($startInfo);
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
            $sjArgs = array($lineArray[5]);
            $ksArgs = array(0);
            $drArgs = array(); //assignment in DRMode
            $lrArgs = array();
            $storgePath = "G:/Taruca/data/";
            $rnaVcfFilePath = $storgePath .$rnaVcfName;
            $dnaVcfFilePath = $storgePath .$dnaVcfName;

            if($rnaVcfName !== "null") {
                //denove mode
                //load RNAVcfFile
                $rnaVcfTableNameArray = RNAVCFParser::parseMultiRNAVCFFile($con, $rnaVcfFilePath, $userid);
                if($dnaVcfName !== "null") {
                    $dnaVcfTableNameArray = DNAVCFParser::parseMultiDNAVCFFile($con, $dnaVcfFilePath, $userid);
                }

                if(count($rnaVcfTableNameArray) != 0) {
                    $i = 0;
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

                        if ($dnaVcfName == "null") {
                            REDTools::writeTableIntoDb($con, $userid, $ksTableName);
                        } else {
                            if(count($dnaVcfTableNameArray) == count($rnaVcfTableNameArray)) {
                                $drTableName = REDTools::getFirstHalfTableName($ksTableName) .DNARNAFilter::getName() ."_" .date("Ymdhisa");
                                $drArgs[0] = $dnaVcfTableNameArray[$i];
                                $drArgs[1] = $lineArray[6];
                                DNARNAFilter::performDNARNAFilter($con, $ksTableName, $drTableName, $drArgs);

                                $lrTableName = REDTools::getFirstHalfTableName($drTableName) .LikelihoodRateFilter::getName() ."_" .date("Ymdhisa");
                                $lrArgs[0] = $dnaVcfTableNameArray[$i];
                                $lrArgs[1] = $lineArray[7];
                                LikelihoodRateFilter::performLikelihoodRateFilter($con, $drTableName, $lrTableName, $lrArgs);
                                REDTools::writeTableIntoDb($con, $userid, $lrTableName);

                            } else {
                                REDLog::writeErrLog("The num of DNA sample is different from RNA sample, please check your vcf file");
                            }
                        }

                        $i++;
                    }

                } else {
                    REDLog::writeErrLog("There is no rnaVcfTables");
                }
            }
            $endInfo = "------------------------\r\n" ."------------------------\r\n" ."RNA Editing Detector end\r\n";
            REDLog::writeInfoLog("$endInfo");

        } else {
            //sleep 10 minute，20s to test
            sleep(20);
            self::executeFilters();
        }

    }

}


?>