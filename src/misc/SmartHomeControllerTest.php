<?php

namespace App\misc;

use App\Misc\SmartHomeController;
use PHPUnit\Framework\TestCase;

class SmartHomeControllerTest extends TestCase
{
    //night - se detecta movimiento => se enciende

    public function testSiEsNightYSeDetectaMovimientoSeDebeEncenderLaBombilla() {
        // Setup: es night y se detecta movimiento
        $motionDetected = true;
        $timeUtilsMock = $this->createPartialMock(TimeUtils::class, ['getDateNow']);
        $backyardSwitcherMock = new BackyardSwitcherMock();

        $time = '03';
        $timeUtilsMock
            ->method('getDateNow')
            ->willReturn($time);

        $controller = new SmartHomeController($timeUtilsMock, $backyardSwitcherMock);

        // Act
        $controller->actuateLights($motionDetected,$time, true);

        // Assert: Verificar que se enciende la bombilla
        $this->assertEquals(true, $backyardSwitcherMock->turnOnHasBeenCalled);
    }

    public function testSiEsMorningYSeDetectaMovimientoSeDebeApagarLaBombilla() {
        // Setup: es night y se detecta movimiento
        $motionDetected = true;
        $timeUtilsMock = $this->createPartialMock(TimeUtils::class, ['getDateNow']);
        $backyardSwitcherMock = new BackyardSwitcherMock();

        $time = '10';
        $timeUtilsMock
            ->method('getDateNow')
            ->willReturn($time);

        // Act
        $controller = new SmartHomeController($timeUtilsMock, $backyardSwitcherMock);
        $controller->actuateLights($motionDetected,$time, false);

        // Assert: Verificar que se enciende la bombilla
        $this->assertFalse($backyardSwitcherMock->turnOnHasBeenCalled);
        $this->assertTrue($backyardSwitcherMock->turnOffHasBeenCalled);
    }

//morning - se detecta movimiento => se apaga
//night - NO se detecta movimiento, ha pasado menos de un minuto => se queda igual
//night - NO se detecta movimiento, ha pasado más de un minuto => se apaga

    public function testIsNightNoMovimientoMenosDeUnMinuto()
    {
        // Setup: es night y se detecta movimiento
        $motionDetected = false;
        $timeUtilsMock = $this->createPartialMock(TimeUtils::class, ['getDateNow']);
        $backyardSwitcherMock = new BackyardSwitcherMock();

        $time = '01';
        $timeUtilsMock
            ->method('getDateNow')
            ->willReturn($time);

        $controller = new SmartHomeController($timeUtilsMock, $backyardSwitcherMock);

        // Act
        $controller->actuateLights($motionDetected,$time, true);

        // Assert: Verificar que se enciende la bombilla
        $this->assertEquals(false, $backyardSwitcherMock->turnOnHasBeenCalled);
        $this->assertEquals(false, $backyardSwitcherMock->turnOffHasBeenCalled);

    }

    public function testIsNightNoMovimientoMasDeUnMinuto()
    {
        // Setup: es night y se detecta movimiento
        $motionDetected = false;
        $timeUtilsMock = $this->createPartialMock(TimeUtils::class, ['getDateNow']);
        $backyardSwitcherMock = new BackyardSwitcherMock();

        $time = '01';
        $timeUtilsMock
            ->method('getDateNow')
            ->willReturn($time);

        $controller = new SmartHomeController($timeUtilsMock, $backyardSwitcherMock);

        // Act
        $controller->actuateLights($motionDetected, $time, true);

        // Assert: Verificar que se enciende la bombilla
        $this->assertEquals(false, $backyardSwitcherMock->turnOnHasBeenCalled);
        $this->assertEquals(true, $backyardSwitcherMock->turnOffHasBeenCalled);
    }
}
