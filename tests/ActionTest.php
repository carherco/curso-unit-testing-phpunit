<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Action;

class ActionTest extends TestCase 
{
  public function testAddSaldoShouldCallAgencyManagerWithCorrectParamsAndReturnOutput() {
    // Setup
    $containerMock = $this->createMock(App\Deps\ContainerInterface::class);
    $dummyAgency = 'dummyAgency';
    $dummyAmount = 'dummyAmount';
    $dummySaldoAvail = 457.75;

    $agencyManagerMock = $this->createMock(App\AgencyManager::class);
    $agencyManagerMock->method('addSaldo')
        ->will($this->returnValue($dummySaldoAvail));
    
    $appExceptionMock = $this->createMock(App\Deps\AppException::class);

    $containerMock->method('get')
        ->with($this->equalTo('ws.agency.manager'))
        ->will($this->returnValue($agencyManagerMock));

    // Assert
    $agencyManagerMock->expects($this->once())
                     ->method('addSaldo')
                     ->with($this->equalTo($dummyAgency,$dummyAmount));

    // Act
    $sut = new Action($containerMock);
    $output = $sut->addSaldo($dummyAgency, $dummyAmount);

    // Assert
    $this->assertEquals($dummySaldoAvail, $output);
  }

  public function testAddSaldoShouldCallMonologWhenAgencyManagerThrowsException() {
    // Setup
    $containerMock = $this->createMock(App\Deps\ContainerInterface::class);
    $dummyAgency = 'dummyAgency';
    $dummyAmount = 'dummyAmount';

    $agencyManagerMock = $this->createMock(App\AgencyManager::class);
    $dummyException = new Exception();
    $dummyTrace = $dummyException->getTraceAsString();
    $agencyManagerMock->method('addSaldo')
        ->will($this->throwException($dummyException));
    
    $appExceptionMock = $this->createMock(App\Deps\AppException::class);

    $containerMock->method('get')
        ->withConsecutive(['ws.agency.manager'], ['monolog.logger.AppException'])
        ->willReturnOnConsecutiveCalls($agencyManagerMock, $appExceptionMock);

    // Assert
    $appExceptionMock->expects($this->once())
                     ->method('info')
                     ->with($this->equalTo($dummyTrace));

    // Act                 
    $sut = new Action($containerMock);
    $sut->addSaldo($dummyAgency, $dummyAmount);
  }
}