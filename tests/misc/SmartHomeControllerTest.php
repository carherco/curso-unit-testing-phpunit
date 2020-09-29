<?php
require __DIR__ . '/../../vendor/autoload.php';

use App\Misc\BackyardSwitcher;
use App\Misc\SmartHomeController;
use App\Misc\TimeUtils;
use PHPUnit\Framework\TestCase;

class MockSwitcher {

  public $turnOnHasBeenCalled = false;
  public $turnOffHasBeenCalled = false;

  public function turnOn() {
		$this->turnOnHasBeenCalled = true;
	}
	
	public function turnOff() {
		$this->turnOffHasBeenCalled = true;
	}
}


class SmartHomeControllerTest extends TestCase {

  public function testShouldTurnOnLightWhenIsEveningAndMotionDetectedIsTrue() {
    
    // Set Up
    $timeUtils = new TimeUtils(); 
    $mockSwitcher = new MockSwitcher();
    $mockTime = $time = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 20:59:08');

    $myController = new SmartHomeController($timeUtils, $mockSwitcher);

    // Act
    $myController->actuateLights($mockTime, true);

    // Assert
    $this->assertTrue($mockSwitcher->turnOnHasBeenCalled);
  }

  public function testShouldTurnOffLightWhenPassesMoreThan1Minute() {
    
    // Set Up
    $timeUtils = new TimeUtils(); 
    $mockSwitcher = new MockSwitcher();
    $mockTime = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 20:59:08');

    $myController = new SmartHomeController($timeUtils, $mockSwitcher);
    $myController->actuateLights($mockTime, true);
    $mockTime2 = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 21:00:09');

    // Act
    $myController->actuateLights($mockTime2, false);
    
    // Assert
    $this->assertTrue($mockSwitcher->turnOffHasBeenCalled);
  }

  public function testShouldCallTurnOnWhenIsNightAndMotionDetectedIsTrue() {
    
    // Set Up
    $timeUtils = new TimeUtils(); 
    // $mockSwitcher = new MockSwitcher();
    $mockSwitcher = $this->createMock(App\Misc\BackyardSwitcher::class);
    $mockTime = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 02:59:08');

    $myController = new SmartHomeController($timeUtils, $mockSwitcher);

    // Assert
    $mockSwitcher->expects($this->once())
                     ->method('turnOn');
           
    // Act
    $myController->actuateLights($mockTime, true);
  }
  
}