<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Misc\DNI;

class DNITest extends TestCase {


  public function testCalcularLetra(){
    $myClass = new DNI();
    $output = $myClass->calcularLetra(15454424);

    $this->assertEquals('B', $output);
  }
}