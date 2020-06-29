<?php 

namespace App;

class Calculation {  
  	
	// input: [2, 6, 9], output: 9
	// input: [-4, 2, -5], output: 2
    public function findMax($arr) {  
        $max = $arr[0];
        for($i=0;$i<count($arr);$i++){  
            if($max<$arr[$i])  
                $max=$arr[$i];  
        }  
        return $max;  
    }   
     
    // input: "Hola qué tal", output: "aloH éuq lat"
    // public function reverseWord($str){  
  
    //     StringBuilder result=new StringBuilder();  
    //     StringTokenizer tokenizer=new StringTokenizer($str," ");  
  
    //     while(tokenizer.hasMoreTokens()){  
	//         StringBuilder $sb=new StringBuilder();  
	//         sb.append(tokenizer.nextToken());  
	//         sb.reverse();  
	  
	//         result.append(sb);  
	//         result.append(" ");  
    //     }
        
    //     return result.toString().trim();  
    // }  
}  