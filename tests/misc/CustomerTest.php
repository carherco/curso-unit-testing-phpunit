<?php

namespace misc;

use App\misc\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCustomerNegativeAge() {
        $customer = new Customer();

        // Assert
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage("No puede ser un número negativo");

        // Act
        $customer->setAge(-32);
    }

    public function testCustomerPositiveAge() {
        $customer = new Customer();

        // Act
        $customer->setAge(32);

        // Assert
        $this->assertEquals(32, $customer->getAge());
    }
}
