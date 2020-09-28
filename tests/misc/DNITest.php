<?php
require __DIR__ . '/../../vendor/autoload.php';

use App\Misc\DNI;
use PHPUnit\Framework\TestCase;

class DNITest extends TestCase {

  // public function testCalcularLetraDNI(){
  //   $myClass = new DNI();
  //   $input = 15454424;
  //   $output = $myClass->calcularLetra($input);
  //   $this->assertEquals('B', $output);  
  // } 

  // public function testCalcularLetraDNI2(){
  //   $myClass = new DNI();
  //   $input = 24391544;
  //   $output = $myClass->calcularLetra($input);
  //   $this->assertEquals('K', $output);  
  // } 

  // public function testCalcularLetraDNI3(){
  //   $myClass = new DNI();
  //   $input = 70878790;
  //   $output = $myClass->calcularLetra($input);
  //   $this->assertEquals('N', $output);  
  // } 

  /**
   * @dataProvider calcularLetraProvider
   */
  public function testCalcularLetra($dni, $expectedOtuput){
    $myClass = new DNI();
    $output = $myClass->calcularLetra($dni);
    $this->assertEquals($expectedOtuput, $output);  
  } 

  public function calcularLetraProvider()
  {
    return [
      [15454423, 'X'],
      [15454424, 'B'],
      [43253425, 'Q'],
      [24391544, 'K'],
      [70878790, 'N'],
      [39696838, 'B'],
      [23,       'T'], 
      [10101010, 'P'],
      [10101020, 'H'],
      [12345678, 'Z'],
      [11111116, 'T'],
      [11111117, 'R'],
      [11111118, 'W'],
      [11111119, 'A'],
      [11111120, 'G'],
      [11111121, 'M'],
      [11111122, 'Y'],
      [11111123, 'F'],
      [11111124, 'P'],
      [11111125, 'D'],
      [11111126, 'X'],
      [11111127, 'B'],
      [11111128, 'N'],
      [11111129, 'J'],
      [11111130, 'Z'],
      [11111131, 'S'],
      [11111132, 'Q'],
      [11111133, 'V'],
      [11111134, 'H'],
      [11111135, 'L'],
      [11111136, 'C'],
      [11111137, 'K'],
      [11111138, 'E']
    ];
  }
}