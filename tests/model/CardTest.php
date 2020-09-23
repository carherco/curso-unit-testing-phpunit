<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Model\Card;

class CardTest extends TestCase 
{
  public function testGetExpireDateWithDefaultFormat() {
    // Arrange (Set up)
    $myClass = new Card();
    $myClass->setExpireMonth('10');
    $myClass->setFullYear('2021');

    // Act
    $output = $myClass->getExpireDate();

    // Assert
    $this->assertEquals('10/2021', $output);
  }

  public function testGetExpireDateWithDefaultFormatAnd1DigitMonth() {
    // Arrange (Set up)
    $myClass = new Card();
    $myClass->setExpireMonth('3');
    $myClass->setFullYear('2021');

    // Act
    $output = $myClass->getExpireDate();

    // Assert
    $this->assertEquals('03/2021', $output);
  }

  /**
   * @dataProvider getExpireDateProvider
   */
  public function testGetExpireDateWithFormat($month, $year, $format, $expectedOutput) {
    // Arrange (Set up)
    $myClass = new Card();
    $myClass->setExpireMonth($month);
    $myClass->setFullYear($year);

    // Act
    $output = $myClass->getExpireDate($format);

    // Assert
    $this->assertEquals($expectedOutput, $output);
  }

  public function getExpireDateProvider()
  {
      return [
          ['03', '2021', 'mm/yyyy', '03/2021'],
          ['03', '2021', 'mm-yyyy', '03-2021'],
          ['03', '2021', 'mmyyyy', '032021'],
          ['03', '2021', 'mm/yy', '03/21'],
          ['03', '2021', 'mm-yy', '03-21'],
          ['03', '2021', 'mmyy', '0321'],
          ['03', '2021', 'yyyy-mm', '2021-03'],
      ];
  }
}