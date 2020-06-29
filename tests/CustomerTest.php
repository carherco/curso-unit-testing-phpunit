<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase {

	public function testSetPositiveAge() {
		$customer = new Customer();
		$customer->setAge(3);
		$this->assertEquals(3, $customer->getAge());
	}

	public function testSetAgeWithNegativeAgeThrowsException() {
		$customer = new Customer();

		$this->expectException(LogicException::class);
		$this->expectExceptionMessage('No puede ser un número negativo');

		$customer->setAge(-1);
		
	}

}
