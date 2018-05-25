<?php 
   $current_year = date("Y");
    $semester=semester();
    function semester(){
        $current_month = date("m");
        if($current_month==1||$current_month==2||$current_month==3||$current_month==4){
            $s='Spring';
            return $s;
        }
        if($current_month==5||$current_month==6||$current_month==7||$current_month==8){
            $s='Summer';
            return $s;
        }
        if($current_month==9||$current_month==10||$current_month==11||$current_month==12){
            $s='Fall';
            return $s;
        }
        
    }
?>