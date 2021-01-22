<?php

    function sexToInt($sex){
        if($sex == 'female') return 1;
        elseif($sex == 'male') return 0;
        else return -1;
    }

    function sizeToInt($size){
        if($size == 'small') return 0;
        elseif($size == 'medium') return 1;
        elseif($size == 'big') return 2;
        else return -1;
    }

    function intToSex($i){
        if($i == 1) return 'Female';
        elseif($i == 0) return 'Male';
    }

    function intToSize($i){
        if($i == 0) return 'Small';
        elseif($i == 1) return 'Medium';
        elseif($i == 2) return 'Big';
    }
    
    function parseNameRace($name_race){
        $words = preg_split("/, /", $name_race);
        $n = count($words);

        if($n == 2){
            return array($words[0], $words[1]);
        }
        elseif($n == 1){
            return array($words[0], "");
        }
        else{
            return "";
        }
 
    }

?>