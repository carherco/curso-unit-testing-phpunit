<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\AppExtension;

class AppExtensionTest extends TestCase 
{
  public function testSfCalculator() {
    $myClass = new AppExtension(null);

    $input = 100;
    $expectedOutput = 21;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator2() {
    $myClass = new AppExtension(null);

    $input = 1;
    $expectedOutput = 21;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator3() {
    $myClass = new AppExtension(null);

    $input = 1.25;
    $expectedOutput = 20.75;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator4() {
    $myClass = new AppExtension(null);

    $input = 17.01;
    $expectedOutput = 20.99;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  public function testSfCalculator5() {
    $myClass = new AppExtension(null);

    $input = 28.99;
    $expectedOutput = 20.01;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }

  /**
   * @dataProvider sfCalculatorProvider
   */
  public function testSfCalculator6($input, $expectedOutput) {
    $myClass = new AppExtension(null);
    
    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }


  public function sfCalculatorProvider()
  {
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

  /**
   * @dataProvider paxtype2textProvider
   */
  public function testPaxtype2text($passengerType, $expectedOutput) {
    $myClass = new AppExtension(null);

    $this->assertEquals($expectedOutput, $myClass->paxtype2text($passengerType));
  }

  public function paxtype2textProvider()
  {
      return [
        'should return adulto when content is ADT' => ['ADT', 'adulto'],
        'should return niño when content is CHD' => ['CHD', 'niño'],
        'should return bebé when passeger Type is INF' => ['INF', 'bebé'],
        'should return the original content when content is not one of above' => ['XYZ', 'XYZ'],
    ];
  }

  public function testStringDiffDateOneMinuteOfDifference() 
  {
    // Setup
    $myClass = $this->getMockBuilder(AppExtension::class) // Este método hace una copia exacta del original
      ->disableOriginalConstructor()
      ->setMethods(['getDateTimeNow']) // Con setMethods alteramos el comportamiento de los métodos que elijamos. El resto de métodos funcionan de la forma original
      ->getMock();

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:02:10');
    $myClass
      ->method('getDateTimeNow')
      ->willReturn($date);

    // Act
    $input = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:01:08');
    $output = $myClass->stringDiffDate($input);


    // Assert
    $this->markTestIncomplete('Desactivado temporalmente.');
    $this->assertEquals('Hace 1 minuto', $output);

  }

  public function testStringDiffDateSomeMinutesOfDifference() 
  {
    // Setup
    $myClass = $this->getMockBuilder(AppExtension::class)
      ->disableOriginalConstructor()
      ->setMethods(['getDateTimeNow'])
      ->getMock();

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:02:10');
    $myClass
      ->method('getDateTimeNow')
      ->willReturn($date);

    // Act
    $input = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 08:59:08');
    $output = $myClass->stringDiffDate($input);


    // Assert
    $this->assertEquals('Hace 3 minutos', $output);
  }

  public function testStringDiffDateOneHourOfDifference() 
  {
    // Setup
    $myClass = $this->getMockBuilder(AppExtension::class)
      ->disableOriginalConstructor()
      ->setMethods(['getDateTimeNow'])
      ->getMock();

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:02:10');
    $myClass
      ->method('getDateTimeNow')
      ->willReturn($date);

    // Act
    $input = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 08:01:08');
    $output = $myClass->stringDiffDate($input);


    // Assert
    $this->assertEquals('Hace 1 hora', $output);
  }

  public function testStringDiffDateSomeHoursOfDifference() 
  {
    // Setup
    $myClass = $this->getMockBuilder(AppExtension::class)
      ->disableOriginalConstructor()
      ->setMethods(['getDateTimeNow'])
      ->getMock();

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:02:10');
    $myClass
      ->method('getDateTimeNow')
      ->willReturn($date);

    // Act
    $input = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 04:01:08');
    $output = $myClass->stringDiffDate($input);


    // Assert
    $this->assertEquals('Hace 5 horas', $output);
  }
  
}
  