<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\AppExtension;

class AppExtensionTest extends TestCase {

  public function testSfCalculator() {
    $myClass = new AppExtension(null);
    $output = $myClass->sfCalculator(100);

    $this->assertEquals(21, $output);
  }

  public function testSfCalculator2() {
    $myClass = new AppExtension(null);
    $output = $myClass->sfCalculator(1);

    $this->assertEquals(21, $output);
  }

  public function testSfCalculator3() {
    $myClass = new AppExtension(null);
    $output = $myClass->sfCalculator(15.25);

    $this->assertEquals(20.75, $output);
  }

  public function testSfCalculator4() {
    $myClass = new AppExtension(null);
    $output = $myClass->sfCalculator(15.257);

    $this->assertEquals(20.74, $output);
  }

  public function testPaxtype2TextShouldReturnStringAdultoWhenPassengerTypeIsStringAdt() {
    $myClass = new AppExtension(null);
    $output = $myClass->paxtype2text('ADT');

    $this->assertEquals('adulto', $output);
  }

  public function testPaxtype2TextShouldReturnNinoWhenPassengerTypeIsChd() {
    $myClass = new AppExtension(null);
    $output = $myClass->paxtype2text('CHD');

    $this->assertEquals('niño', $output);
  }

  public function testPaxtype2TextShouldReturnBebeWhenPassengerTypeIsInf() {
    $myClass = new AppExtension(null);
    $output = $myClass->paxtype2text('INF');

    $this->assertEquals('bebé', $output);
  }

  public function testPaxtype2TextShouldReturnOriginalContentWhenPassengerTypeIsNotOneOfAbove() {
    $myClass = new AppExtension(null);
    $output = $myClass->paxtype2text('Other');

    $this->assertEquals('Other', $output);
  }

}