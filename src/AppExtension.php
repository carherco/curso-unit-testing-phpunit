<?php

namespace App;

class AppExtension
{
  public function durationdays( $duration ) 
  {    
      $content = '?';
      switch ($content) {
        case 'ADT':
            return 'adulto';
          break;
        case 'CHD':
            return 'niño';
          break;
        case 'INF':
          return 'bebé';
          break;                    
        default:
            return $content;
          break;
      }
  }
  
  public function sfCalculator( $value )
  {
      $rest = round( $value - floor( $value ) , 2);
      $decimals = round( (1 - $rest), 2, PHP_ROUND_HALF_DOWN);
      $sf_b2b = 20 + $decimals;
      return $sf_b2b;
  }   
}