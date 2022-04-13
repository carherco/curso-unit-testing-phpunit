<?php

namespace App\misc;

use LogicException;

class Customer {
    
	private $age;

    public function setAge($age) {
        if ($age < 0) {
            throw new LogicException("No puede ser un número negativo");
        }
        $this->age = $age;
    }

	public function getAge() {
		return $this->age;
	}
	
}
