<?php 

namespace App\misc;

class Calculation {  
  	
	// input: [2, 6, 9], output: 9
	// input: [-4, 2, -5], output: 2
    public function findMax($arr) {  
        $max = 0;
        for($i=1;$i<count($arr);$i++){
            if($max<$arr[$i]) {
                $max = $arr[$i];
            }
        }  
        return $max;  
    }   
     
     // input: "Hola qué tal", output: "aloH éuq lat"
     public function reverseWord(string $str){
         $reversed = "";
         $tmp = "";
         for($i = 0; $i < strlen($str); $i++) {
             if($str[$i] == " ") {
                 $reversed .= $tmp . " ";
                 $tmp = "";
                 continue;
             }
             $tmp = $str[$i] . $tmp;
         }
         $reversed .= $tmp;
         return $reversed;
     }
}  
