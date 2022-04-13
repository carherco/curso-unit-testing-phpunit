<?php 

namespace App\misc;

class Calculation {  
  	
	// input: [2, 6, 9], output: 9
	// input: [-4, 2, -5], output: 2
    public function findMax(array $arr) : int {
        $max = $arr[0];
        for($i=1;$i<count($arr);$i++){
            if($max<$arr[$i]) {
                $max = $arr[$i];
            }
        }  
        return $max;  
    }   

     // input: "Hola qué tal", output: "aloH éuq lat"
     public function reverseWord(string $str): string {
         $wordChars = 'abcdefghijklmnopqrstuvwxyz';
         $buffer = '';
         $return = '';
         $len = strlen($str);
         $i = 0;
         while ($i < $len) {
             $chr = $str[$i];
             if (((int)$chr & 0xC0) == 0xC0) {
                 //UTF8 Characer!
                 if (($chr & 0xF0) == 0xF0) {
                     //4 Byte Sequence
                     $chr .= substr($str, $i + 1, 3);
                     $i += 3;
                 } elseif (($chr & 0xE0) == 0xE0) {
                     //3 Byte Sequence
                     $chr .= substr($str, $i + 1, 2);
                     $i += 2;
                 } else {
                     //2 Byte Sequence
                     $i++;
                     $chr .= $str[$i];
                 }
             }
             if (stripos($wordChars, $chr) !== false) {
                 $buffer = $chr . $buffer;
             } else {
                 $return .= $buffer . $chr;
                 $buffer = '';
             }
             $i++;
         }
         return $return . $buffer;
     }
}  
