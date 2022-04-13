<?php

namespace misc;

use App\misc\DNI;
use phpDocumentor\Reflection\Types\Boolean;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertTrue;

class DNITest extends TestCase
{
    /**
     * @test
     * @dataProvider dniLetterResult
     */
    public function test_DNI(string $expected, int $number): void
    {
        $dni = new DNI();
        $dniNumber = $dni->calcularLetra($number);

        $this->assertEquals($expected, $dniNumber);
    }

    public function dniLetterResult(): array
    {
        return [
            'Caso 0' => ['T', 74860124],
            'Caso 1' => ['R', 74860125],
            'Caso 2' => ['W', 74860126],
            'Caso 3' => ['A', 74860127],
            'Caso 4' => ['G', 74860128],
            'Caso 5' => ['M', 74860129],
            'Caso 6' => ['Y', 74860130],
            'Caso 7' => ['F', 74860131],
            'Caso 8' => ['P', 74860132],
            'Caso 9' => ['D', 74860133],
            'Caso 10' => ['X', 74860134],
            'Caso 11' => ['B', 74860135],
            'Caso 12' => ['N', 74860136],
            'Caso 13' => ['J', 74860137],
            'Caso 14' => ['Z', 74860138],
            'Caso 15' => ['S', 74860139],
            'Caso 16' => ['Q', 74860140],
            'Caso 17' => ['V', 74860141],
            'Caso 18' => ['H', 74860142],
            'Caso 19' => ['L', 74860143],
            'Caso 20' => ['C', 74860144],
            'Caso 21' => ['K', 74860145],
            'Caso 22' => ['E', 74860146],
        ];
    }

}
