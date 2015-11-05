<?php
class REDTools {
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
}
?>
