<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Calculation;
use PHPUnit\Framework\TestCase;

class CalculationTest extends TestCase {

    public function testFindMax(){
			$c = new Calculation();
			$input = [1,3,4,2];
			$output = $c->findMax($input);
			$this->assertEquals(4, $output);  
    } 

    public function testFindMaxWhenMaxIsFirstElement(){  
			$c = new Calculation();
			$input = [7, 3, 2, -6];
			$output = $c->findMax($input);
			$this->assertEquals(7, $output);  
    }
	
    public function testFindMaxWhenMaxIsLastElement(){  
			$c = new Calculation();
			$input = [1,3,14,19];
			$output = $c->findMax($input);
			$this->assertEquals(19, $output);
    }
	
    public function testFindMaxWhenMaxIsRepeated(){  
			$c = new Calculation();
			$input = [14,3,14,9];
			$output = $c->findMax($input);
			$this->assertEquals(14, $output);
    }
	 
	public function testFindMaxWithNegativeNumbers(){  
		$c = new Calculation();
		$input = [-18,-1,-14,-9];
		$output = $c->findMax($input);
		$this->assertEquals(-1, $output);
	}
	
	public function testFindMaxWith1Element() {
		$c = new Calculation();
		$input = [3];
		$output = $c->findMax($input);
		$this->assertEquals(3, $output);
	}
	 
  // public function testReverseWord(){ 
	// 	$c = new Calculation(); 
	// 	$input = "Hola qué tal";
	//   $actualOutput = $c->reverseWord($input);
  //   $this->assertEquals("aloH éuq lat", $actualoutput);  
  // } 

}
