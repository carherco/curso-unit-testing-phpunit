<?php
require __DIR__ . '/../../vendor/autoload.php';

use App\Misc\TimeUtils;
use PHPUnit\Framework\TestCase;

class TimeUtilsTest extends TestCase {

  public function testGetTimeOfDayShouldReturnStringNightWhenTimeIsBetween0And6() {
    $myClass = new TimeUtils();
    $time = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 03:59:08');

    $output = $myClass->getTimeOfDay($time);

    $this->assertEquals('Night', $output);
  }

  public function testGetTimeOfDayShouldReturnStringMorningWhenTimeIsBetween6And12() {
    $myClass = new TimeUtils();
    $time = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 10:59:08');

    $output = $myClass->getTimeOfDay($time);

    $this->assertEquals('Morning', $output);
  }

  public function testGetTimeOfDayShouldReturnStringAfternoonWhenTimeIsBetween12And18() {
    $myClass = new TimeUtils();
    $time = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 17:59:08');

    $output = $myClass->getTimeOfDay($time);

    $this->assertEquals('Afternoon', $output);
  }

  public function testGetTimeOfDayShouldReturnStringEveningWhenTimeIsBetween18And24() {
    $myClass = new TimeUtils();
    $time = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 23:59:08');

    $output = $myClass->getTimeOfDay($time);

    $this->assertEquals('Evening', $output);
  }
}
