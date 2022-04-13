<?php

namespace misc;

use App\misc\SwitcherInterface;
use App\misc\MotionDetectorInterface;
use App\misc\SmartHomeController;
use App\misc\TimeUtils;
use PHPUnit\Framework\TestCase;

class SmartHomeControllerTest extends TestCase
{
    /**
     * @testdox De madrugada y con detección de movimiento => Se debería encender la bombilla
     */
    public function testGivenIsNightAndMotionHasBeenDetected_ItMustTurnOnLight()
    {
        // SETUP / GIVEN
        $motionDetected = true;
        $time = new \DateTime('2022-03-07 3:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->once())->method('turnOn');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox Evening y con detección de movimiento => Se debería encender la bombilla
     */
    public function testGivenIsEveningAndMotionHasBeenDetected_ItMustTurnOnLight()
    {
        // SETUP / GIVEN
        $motionDetected = true;
        $time = new \DateTime('2022-03-07 21:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->once())->method('turnOn');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox Morning y con detección de movimiento => Se debería apagar la bombilla
     */
    public function testGivenIsMorningAndMotionHasBeenDetected_ItMustTurnOffLight()
    {
        // SETUP / GIVEN
        $motionDetected = true;
        $time = new \DateTime('2022-03-07 08:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->once())->method('turnOff');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox Afternoon y con detección de movimiento => Se apagar apagar la bombilla
     */
    public function testGivenIsAfternoonAndMotionHasBeenDetected_ItMustTurnOffLight()
    {
        // SETUP / GIVEN
        $motionDetected = true;
        $time = new \DateTime('2022-03-07 17:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->once())->method('turnOff');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox De madrugada y SIN detección de movimiento => No hacer nada
     */
    public function testGivenIsNightAndMotionHasNotBeenDetected_ItMustDoNothing()
    {
        // SETUP / GIVEN
        $motionDetected = false;
        $time = new \DateTime('2022-03-07 3:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->never())->method('turnOn');
        $switcherMock->expects($this->never())->method('turnOff');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox Evening y SIN detección de movimiento => No hacer nada
     */
    public function testGivenIsEveningAndMotionHasNotBeenDetected_ItMustDoNothing()
    {
        // SETUP / GIVEN
        $motionDetected = false;
        $time = new \DateTime('2022-03-07 21:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->never())->method('turnOn');
        $switcherMock->expects($this->never())->method('turnOff');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox Morning y SIN detección de movimiento => Se debería apagar la bombilla
     */
    public function testGivenIsMorningAndMotionHasNotBeenDetected_ItMustTurnOffLight()
    {
        // SETUP / GIVEN
        $motionDetected = false;
        $time = new \DateTime('2022-03-07 08:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->once())->method('turnOff');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox Afternoon y con detección de movimiento => Se debería apagar la bombilla
     */
    public function testGivenIsAfternoonAndMotionHasNotBeenDetected_ItMustTurnOffLight()
    {
        // SETUP / GIVEN
        $motionDetected = false;
        $time = new \DateTime('2022-03-07 17:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturn($motionDetected);

        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);

        // Assert
        $switcherMock->expects($this->once())->method('turnOff');

        // Act
        $controller->actuateLights($time);
    }

    /**
     * @testdox De madrugada, SIN detección de movimiento y menos de 1 minuto desde la última detección de movimiento => No hacer nada
     */
    public function testGivenIsNightAndMotionHasNotBeenDetectedAndLessThan1Minute_ItMustDoNothing()
    {
        // SETUP / GIVEN
        $time = new \DateTime('2022-03-07 3:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturnOnConsecutiveCalls(true, false);
        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);
        $controller->actuateLights($time);

        // Assert
        $switcherMock->expects($this->never())->method('turnOn');
        $switcherMock->expects($this->never())->method('turnOff');

        // Act
        $time = new \DateTime('2022-03-07 3:00:59');
        $controller->actuateLights($time);
    }

    /**
     * @testdox De madrugada, SIN detección de movimiento y más de 1 minuto desde la última detección de movimiento => Apagar la bombilla
     */
    public function testGivenIsNightAndMotionHasNotBeenDetectedAndMoreThan1Minute_ItMustTurnOffLights()
    {
        // SETUP / GIVEN
        $time = new \DateTime('2022-03-07 3:00:00');

        $motionDetectorMock = $this->createMock(MotionDetectorInterface::class);
        $motionDetectorMock->method('detect')->willReturnOnConsecutiveCalls(true, false);
        $switcherMock = $this->createMock(SwitcherInterface::class);
        $controller = new SmartHomeController($motionDetectorMock, $switcherMock);
        $controller->actuateLights($time);

        // Assert
        $switcherMock->expects($this->once())->method('turnOff');

        // Act
        $time = new \DateTime('2022-03-07 3:01:01');
        $controller->actuateLights($time);
    }


}
