<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Model\Card;

class CardTest extends TestCase {

  public function testGetExpireDateWithDefaultFormat() {

    // Arrange (SetUp)
    $myClass = new Card();
    $myClass->setExpireMonth(10);
    $myClass->setFullYear(2020);

    // Act
    $output = $myClass->getExpireDate();

    // Assert
    $this->assertEquals('10/2020', $output);
  }

  public function testGetExpireDateWithDefaultFormatWhenMonthHas1Digit() {

    // Arrange (SetUp)
    $myClass = new Card();
    $myClass->setExpireMonth(3);
    $myClass->setFullYear(2020);

    // Act
    $output = $myClass->getExpireDate();

    // Assert
    $this->assertEquals('03/2020', $output);
  }

  /**
   * @dataProvider getExpireDateProvider
   */
  public function testGetExpireDateWithFormat($month, $year, $format, $expectedOuptut) {

    // Arrange (SetUp)
    $myClass = new Card();
    $myClass->setExpireMonth($month);
    $myClass->setFullYear($year);

    // Act
    $output = $myClass->getExpireDate($format);

    // Assert
    $this->assertEquals($expectedOuptut, $output);
  }

  public function getExpireDateProvider()
  {
      return [
          'with format mm/yyyy' => ['3', '2021', 'mm/yyyy', '03/2021'],
          'with format mm-yyyy with 2 digits' => ['10', '2023', 'mm-yyyy', '10-2023'],
          'with format mm-yyyy with 1 digit' => ['4', '2023', 'mm-yyyy', '04-2023'],
          'with format mm/yyyy' => ['1', '2021', 'mmyyyy', '012021'],
          'with format mm/yy' => ['8', '2021', 'mm/yy', '08/21'],
          'with format mm-yy' => ['7', '2021', 'mm-yy', '07-21'],
          'with format mmyy' => ['12', '2021', 'mmyy', '1221'],
          'with format yyyy-mm' => ['3', '2021', 'yyyy-mm', '2021-03'],
      ];
  }
}
