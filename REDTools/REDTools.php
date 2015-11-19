<?php
class REDTools {
    //tested
    function __construct() {}
    /*
     * tested
    */
    static function getNegativeStrandEditingType($editingType) {
        if ($editingType == null || strlen($editingType) != 2) {
            return null;
        }
        $type = $editingType;
        return self::getNegativeStrandBase(substr($type, 0, 1)) .self::getNegativeStrandBase(substr($type, 1, 1));
    }

    /*
     * tested
    */
    static function getNegativeStrandBase($type) {
        switch ($type) {
            case 'A':
                return 'T';
            case 'G':
                return 'C';
            case 'T':
                return 'A';
            case 'C':
                return 'G';
            default:
                return 'T';
        }
    }

    static function getFirstHalfTableName($tableName) {
        //bj22n_ranvcf;bj22n_rnavcf_etfilter;
        $firstHalfTableName = "";
        $tableElement = explode('_', $tableName);
        if (count($tableElement) == 4) {
            $firstHalfTableName = $tableElement[0] ."_" .$tableElement[1] ."_" .$tableElement[2] ."_";
        } else {
            $firstHalfTableName = $tableElement[0] ."_" .$tableElement[1] ."_" .$tableElement[3] ."_";
        }
        return $firstHalfTableName;
    }

    static function getRandomString($length) {
        if ($length < 1) {
            return null;
        }
        $letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $lettersLength = strlen($letters);
        for ($i=0; $i < $length; $i++) {
            $randBuffer[$i] = $letters[rand(0,$lettersLength - 1)];
        }
        $randString = implode($randBuffer);
        return $randString;
    }

    static function readInfoFile($dirPath) {
        $fileArray = scandir($dirPath);
        //get one info file
        if(count($fileArray) == 3) {
            $filePath = $dirPath ."/" .$fileArray[2];
            $fp = fopen($filePath, 'r');
            while(($line = fgets($fp)) != null) {
                $lineContent = trim($line);
                if(strpos($lineContent, '#') === 0) {
                    continue;
                }
                $lineArray = explode("\t", $lineContent);
                //return $lineContent;
                return $lineArray;
            }
        } else {
            return false;
        }
    }

    static function writeTableIntoDb($con, $userid, $tableName) {
        $sqlClause1 = "select tables from users where id = '" .$userid ."'";
        $result = mysqli_query($con, $sqlClause1);
        while($row = mysqli_fetch_array($result)) {
            $priorTable = $row['tables'];
        }

        $nowTables = $priorTable . "/" . $tableName;
        $sqlClause2 = "update users set tables = '" .$nowTables ."' where id = '" .$userid ."'";
        mysqli_query($con, $sqlClause2);

    }

}
?>
