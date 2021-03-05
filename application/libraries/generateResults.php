<?php
class generateResults {
    public static function arrayCount($input){//Liefert die Anzahl der Vorkommen als assoziatives Array zurück
        $result = [];
        foreach($input as $value){
             $result[$value] += 1;
        }
        return $result;
    }
} 
?>