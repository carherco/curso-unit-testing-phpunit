<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\AppExtension;

class AppExtensionTest extends TestCase 
{
  public function testSfCalculator() {
    $myClass = new AppExtension();

    $input = 100;
    $expectedOutput = 21;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator2() {
    $myClass = new AppExtension();

    $input = 1;
    $expectedOutput = 21;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator3() {
    $myClass = new AppExtension();

    $input = 1.25;
    $expectedOutput = 20.75;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator4() {
    $myClass = new AppExtension();

    $input = 17.01;
    $expectedOutput = 20.99;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator5() {
    $myClass = new AppExtension();

    $input = 28.99;
    $expectedOutput = 20.01;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  /**
   * @dataProvider sfCalculatorProvider
   */
  public function testSfCalculator6($input, $expectedOutput) {
    $myClass = new AppExtension();
    
    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }


  public function sfCalculatorProvider()
  {
      // return [
      //     [100, 21],
      //     [1, 21],
      //     [1.25, 20.75],
      //     [17.01, 20.99],
      //     [28.99, 20.01],
      //     [-28.99, 20.01]
      // ];

      return [
        'sin decimales' => [100, 21],
        'con 0' => [1, 21],
        'con decimales' => [1.25, 20.75],
        'con decimales .01' => [17.01, 20.99],
        'con decimales .99' => [28.99, 20.01],
        // 'número negativo con decimales' => [-28.99, 20.01],
        // 'con más de 3 decimales (3er decimal mayor de 5)' => [47.997, 20.01],
        // 'con más de 3 decimales (3er decimal menor de 5)' => [47.004, 20.99]
    ];
  }

  // /**
  //  * @dataProvider sfCalculatorWithNonNegativeNumbersProvider
  //  * @dataProvider sfCalculatorWithNegativeNumbersProvider
  //  */
  // public function testSfCalculator7($input, $expectedOutput) {
  //   $myClass = new AppExtension();
    
  //   $output = $myClass->sfCalculator($input);

  //   $this->assertEquals($expectedOutput, $output);
  // }

  
}
  