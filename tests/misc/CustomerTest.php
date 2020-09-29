<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Misc\Customer;

class CustomerTest extends TestCase {

  public function testSetAgeWithPositiveAge() {
    $myClass = new Customer();

    // Act
    $myClass->setAge(21);

    // Assert
    $this->assertEquals(21, $myClass->getAge());
  }

  public function testSetAgeWithNegativeAgeThrowsLogicException() {
    $myClass = new Customer();

    // Assert
    $this->expectException(LogicException::class);
    $this->expectExceptionMessage("No puede ser un número negativo");

    // Act
    $myClass->setAge(-21);
  }
}