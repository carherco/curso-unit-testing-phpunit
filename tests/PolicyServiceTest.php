<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\PolicyService;

class PolicyServiceTest extends TestCase {
  
  public function testRateParamIsMandatory() {

    // Setup
    $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
    $requestMock = $this->createStub(App\Deps\Request::class);
    $queryMock = $this->createStub(App\Deps\ParameterBag::class);

    $hasMap = [
      ['rate', false],
      ['cn', true],
      ['checkin', true]
    ];

    $getMap = [
      ['rate', null, null],
      ['cn', null, 6],
      ['checkin', null, '2020-09-28']
    ];

    $queryMock->method('has')
       ->will($this->returnValueMap($hasMap));

    $requestMock->query = $queryMock;
    $requestMock->method('get')
      ->will($this->returnValueMap($getMap));

    // Asserts
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Error Processing Request Parameters: Empty obligatory param');
    $this->expectExceptionCode(1);

    // Act
    $myClass = new PolicyService($containerDummy);
    $myClass->policy( $requestMock );    
  }

  public function testCnParamIsMandatory() {

    // Setup
    $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
    $requestMock = $this->createStub(App\Deps\Request::class);
    $queryMock = $this->createStub(App\Deps\ParameterBag::class);

    $hasMap = [
      ['rate', true],
      ['cn', false],
      ['checkin', true]
    ];

    $getMap = [
      ['rate', null, null],
      ['cn', null, 6],
      ['checkin', null, '2020-09-28']
    ];

    $queryMock->method('has')
       ->will($this->returnValueMap($hasMap));

    $requestMock->query = $queryMock;
    $requestMock->method('get')
       ->will($this->returnValueMap($getMap));

    // Asserts
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Error Processing Request Parameters: Empty obligatory param');
    $this->expectExceptionCode(1);

    // Act
    $myClass = new PolicyService($containerDummy);
    $myClass->policy( $requestMock );    
  }

  public function testCheckinParamIsMandatoryAndThrowsExceptionIfNotProvided() {

    // Setup
    $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
    $requestMock = $this->createStub(App\Deps\Request::class);
    $queryMock = $this->createStub(App\Deps\ParameterBag::class);

    $hasMap = [
      ['rate', true],
      ['cn', true],
      ['checkin', false]
    ];

    $getMap = [
      ['rate', null, null],
      ['cn', null, 6],
      ['checkin', null, '2020-09-28']
    ];

    $queryMock->method('has')
       ->will($this->returnValueMap($hasMap));

    $requestMock->query = $queryMock;
    $requestMock->method('get')
      ->will($this->returnValueMap($getMap));

    // Asserts
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Error Processing Request Parameters: Empty obligatory param');
    $this->expectExceptionCode(1);

    // Act
    $myClass = new PolicyService($containerDummy);
    $myClass->policy( $requestMock );    
  }

  public function testCheckinParamMustBeWellFormatted() {

    // Setup
    $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
    $requestMock = $this->createStub(App\Deps\Request::class);
    $queryMock = $this->createStub(App\Deps\ParameterBag::class);

    $hasMap = [
      ['rate', true],
      ['cn', true],
      ['checkin', true]
    ];

    $getMap = [
      ['rate', null, 3],
      ['cn', null, 6],
      ['checkin', null, '20200928']
    ];

    $queryMock->method('has')
       ->will($this->returnValueMap($hasMap));

    $requestMock->query = $queryMock;
    $requestMock->method('get')
      ->will($this->returnValueMap($getMap));

    // Asserts
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Error Processing Request Parameters: From format');
    $this->expectExceptionCode(2);

    // Act
    $myClass = new PolicyService($containerDummy);
    $myClass->policy( $requestMock );    
  }

  public function testWhenRateManagerThrowsExceptionShouldBypassException() {
    $containerMock = $this->createStub(App\Deps\ContainerInterface::class);
    $requestMock = $this->createStub(App\Deps\Request::class);
    $queryMock = $this->createStub(App\Deps\ParameterBag::class);
    $rateManagerMock = $this->createStub(App\RateManager::class);

    $hasMap = [
      ['rate', true],
      ['cn', true],
      ['checkin', true]
    ];

    $getMap = [
      ['rate', null, 3],
      ['cn', null, 6],
      ['checkin', null, '2020-09-28']
    ];

    $queryMock->method('has')
       ->will($this->returnValueMap($hasMap));

    $requestMock->query = $queryMock;
    $requestMock->method('get')
      ->will($this->returnValueMap($getMap));

    $rateManagerMock->method('find')
      ->will($this->throwException(new \Exception("Rate does not found!!", 1014)));
      
    $containerMock->method('get')
      ->will($this->returnValue($rateManagerMock));
  
    // Asserts
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Rate does not found!!');
    $this->expectExceptionCode(1014);

    // Act
    $myClass = new PolicyService($containerMock);
    $myClass->policy( $requestMock );    
  }

  public function testXXXXXX() {
    $containerMock = $this->createStub(App\Deps\ContainerInterface::class);
    $requestMock = $this->createStub(App\Deps\Request::class);
    $queryMock = $this->createStub(App\Deps\ParameterBag::class);
    $rateManagerMock = $this->createStub(App\RateManager::class);

    $hasMap = [
      ['rate', true],
      ['cn', true],
      ['checkin', true]
    ];

    $getMap = [
      ['rate', null, 3],
      ['cn', null, 6],
      ['checkin', null, '2020-09-28']
    ];

    $queryMock->method('has')
       ->will($this->returnValueMap($hasMap));

    $requestMock->query = $queryMock;
    $requestMock->method('get')
      ->will($this->returnValueMap($getMap));

    $rateManagerMock->method('find')
      ->will($this->throwException(new \Exception("Rate does not found!!", 1014)));
      
    $containerMock->method('get')
      ->will($this->returnValue($rateManagerMock));
  
    // Asserts
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Rate does not found!!');
    $this->expectExceptionCode(1014);

    // Act
    $myClass = new PolicyService($containerMock);
    $myClass->policy( $requestMock );    
  }
}




