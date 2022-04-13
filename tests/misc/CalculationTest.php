<?php

namespace misc;

use App\misc\Calculation;
use PHPUnit\Framework\TestCase;

class CalculationTest extends TestCase
{
    /**
     * @test
     * @dataProvider findMaxData
     */
    public function test_findMax(array $inputNumbers, int $expectedMax ): void
    {
        $calculation = new Calculation();
        $max = $calculation->findMax($inputNumbers);

        $this->assertSame($expectedMax, $max);
    }

    public function findMaxData(): array
    {
        return [
            'Con mezcla positivos negativos' => [[-4, 2, -5], 2],
            'Con positivos' => [[2, 6, 9], 9],
            'Con repetidos' => [[8, 7, 8], 8],
            'Con array de un elemento' => [[8], 8],
            'Con negativos' => [[-2, -6, -9], -2],
            'Con el mayor es el primero' => [[12, 6, 9], 12],
            'Con el mayor es el último' => [[12, 6, 19], 19],
        ];
    }

    /**
     * @test
     * @dataProvider reverseWordsData
     */
    public function test_reverseWords(string $input, string $expected): void
    {
        $calculation = new Calculation();
        $reversed = $calculation->reverseWord($input);

        $this->assertSame($expected, $reversed);
    }

    public function reverseWordsData(): array
    {
        return [
            'sin caracteres extraños' => ['Hola que tal', 'aloH euq lat'],
            //'con tilde' => ['Hola qué tal', 'aloH éuq lat'],
            'con coma' => ['Hola, que tal', 'aloH, euq lat'],
            'con exclamaciones' => ['¡Hola! que tal', '¡aloH! euq lat'],
            'con interrogantes' => ['Hola ¿que tal?', 'aloH ¿euq lat?'],
            //'con todo' => ['¡Hola!, ¿qué tal?', '¡aloH!, ¿éuq lat?'],
        ];
    }
}
