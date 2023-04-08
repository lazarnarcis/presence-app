<?php
    class Functions {
        function transformDate($date) {
            $time=strtotime($date);
            $month=date("F",$time);
            $year=date("Y",$time);
            $new_date = $month.", ".$year;
    
            return $new_date;
        }
    
        function transformSeconds ($seconds) {
            return gmdate("H:i:s", $seconds);
        }

        function dateName($date) {
            $result = "";
    
            $convert_date = strtotime($date);
            $month = date('F',$convert_date);
            $year = date('Y',$convert_date);
            $name_day = date('l',$convert_date);
            $day = date('j',$convert_date);
    
            $result = $month . " " . $day . ", " . $year . " - " . $name_day;
            return $result;
        }
    }
?>