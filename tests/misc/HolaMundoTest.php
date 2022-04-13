<?php

namespace misc;

use PHPUnit\Framework\TestCase;
use App\misc\HolaMundo;

class HolaMundoTest extends TestCase
{
    public function testPruebaSumaPositivos() {
        $holaMundo = new HolaMundo();
        $result = $holaMundo->suma(3,7);

        self::assertEquals(10, $result);
    }

    public function testPruebaSumaNegativos() {
        $holaMundo = new HolaMundo();
        $result = $holaMundo->suma(-3,-7);

        self::assertEquals(-10, $result);
    }
}
